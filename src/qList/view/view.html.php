<?php
/**
 * @package views/qList
 * 
 * @desc 答题（题目显示）页的BLL及UI设定
 * @class QuizViewQList
 *
 * @author wangqi
 * @version 2013-03-07
 */
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

/**
 *	对象执行主体分为三个方法
 *	inputFunc()		=> 对所需参数进行处理
 *	analyzeFunc()	=> 执行业务逻辑
 *	displayFunc()	=> 处理返回模板 or AJAX
 *
 */

class QuizViewQList extends JView {
	/** 
	 *	ajax请求标志 
	 *	AJAX_START	=>	(ajax)获取答题开始时间
	 *	AJAX_CURRENT=>	(ajax)获取当前时间
	 *	AJAX_SUBMIT	=>	(ajax)提交试卷
	 *	SHOW_PAGE 	=>	(show)组装页面
	 *
	 */
	private $ajax  = false;
	private $unit_id = 0;
	/* ajax统一返回数据 */
	private $ajaxData = null;
	private $DEFAULT_QA_NUM = 20;
	private $TIME_LIMIT = 3600; /* 1h */
	private $MAX_SCORE = 100;
	private $ERROR = array(
		'NOT_START' => array('code' => 30001, 'msg' => '当前题目未开始，请重新进入答题页'),
		'TIME_OUT'  => array('code' => 30002, 'msg' => '答题时间已结束'),
		'NO_PARAM'  => array('code' => 30003, 'msg' => '未接收到提交数据'),
		'HAD_SUBMIT'=> array('code' => 30004, 'msg' => '当前试卷已提交')
	);

	function inputFunc() {
		$this->ajax = JRequest::getVar('ajax');
		$this->unit_id = JRequest::getVar('unit');
	}

	function analizeFunc() {
		switch ($this->ajax) {
			case 'AJAX_START':
				$this->ajaxStart();
				break;
			case 'AJAX_CURRENT':/* 当前剩余时间 */
				$this->ajaxCurrent();
				break;
			case 'AJAX_SUBMIT':
				$this->ajaxSubmit();
				break;
			case 'SHOW_PAGE':
			default:
				$this->showPage();
				break;
		}
	}

	function displayFunc($tpl) {
		if(count($error = $this->get('Errors'))) {
			JLog::add(implode('<br/>', $errors), JLog::WARNING, 'jerror');
		}
		
		parent::display($tpl);
	}

	function display($tpl = null) {
		$this->inputFunc();
		$this->analizeFunc();
		$this->displayFunc($tpl);
	}

	function ajaxStart() {
		$session = &JFactory::getSession();
		$startTime = $session->get('start_twime');

		if($startTime) {
			/* 数据格式化 */
			$format = array(
				'start_time' => $startTime
			);
			/* 作为ajax请求进行发送 */
			$ajax = new QuizAjax($format);
		} else {
			$format = null;
			$code = $this->ERROR['NOT_START']['code'];
			$msg = $this->ERROR['NOT_START']['msg'];
			$ajax = new QuizAjax($format, $code, $msg);
		}

		$ajax->display();
	}

	function ajaxCurrent() {
		$session = &JFactory::getSession();
		$startTime = $session->get('start_time');
		$useTime = time();
		$currentTime = $useTime - $startTime;

		if($currentTime <= $this->TIME_LIMIT) {
			/* 数据格式化 */
			$format = array(
				'current_time' => $currentTime
			);
			/* 作为ajax请求进行发送 */
			$ajax = new QuizAjax($format);
		} else {
			$format = null;
			$code = $this->ERROR['TIME_OUT']['code'];
			$msg = $this->ERROR['TIME_OUT']['msg'];
			$ajax = new QuizAjax($format, $code, $msg);
		}
		$ajax->display();
	}

	function ajaxSubmit() {
		$session = &JFactory::getSession();
		/* 提交数据获取并自动解析json格式 */
		$result = JRequest::getVar('result', NULL, 'post');
		$qaListLen = $session->get('qa_list_len');

		/* 当数据为空时，返回错误 */
		if(!$result) {
			$code = $this->ERROR['NO_PARAM']['code'];
			$msg = $this->ERROR['NO_PARAM']['msg'];
			$ajax = new QuizAjax($right_list, $code, $msg);
			$ajax->display();
			return;
		}

		if(!$qaListLen) {
			$code = $this->ERROR['HAD_SUBMIT']['code'];
			$msg = $this->ERROR['HAD_SUBMIT']['msg'];
			$ajax = new QuizAjax($right_list, $code, $msg);
			$ajax->display();
			return;
		} else {
			$session -> set('qa_list_len', 0);
		}

		/* 拿到DAL层接口 */
		$model = $this->getModel();

		/* 结果信息打包数组 */
		$right_list = array();
		$right_count = 0;

		$history_list = array();

		/* 提交信息处理与返回值封装 */
		foreach($result as $key => $value) {
			$right = array();
			$history = array();

			$right['qid'] = $value['qid'];
			$right['aid'] = $value['aid'];
			$history['qid'] = $value['qid'];
			$history['aid'] = $value['aid'];

			if($right['qid']) {
				$right['right_answer'] = $model->getRightAnswerListByQid($value['qid']);
			} 

			if($right['aid']) {
				$right['is_right'] = $right['aid'] == $right['right_answer']->a_id;
			} else {
				$right['is_right'] = false;
			}

			if($right['is_right']) {
				$right_count += 1;
			}
			
			array_push($right_list, $right);
			array_push($history_list, $history);
		}

		$score = round($right_count * $this->MAX_SCORE / $qaListLen);

       	$user = JFactory::getUser();
		$model->addHistory($user->id, json_encode($history_list), $score);

		/* 格式化后返回json */
		$ajax = new QuizAjax(array('right_list'=>$right_list, 'score' => $score));
		$ajax->display();
	}

	function showPage() {
		/* 拿到DAL层接口 */
		$model = $this->getModel();
		$session = &JFactory::getSession();

		/* 输出题目数据 */
		$unit = $model->getUnitById($this->unit_id);
		if(!!$unit) {
			$qaList = $model->getQAListByNum($this->DEFAULT_QA_NUM, $this->unit_id);
		} else {
			$qaList = $model->getQAListByNum($this->DEFAULT_QA_NUM);
		}
        $this->assignRef('unit', $unit);
        $this->assignRef('qa_list', $qaList);
        $session -> set('qa_list_len', count($qaList));

        /* 输出用户信息 */
       	$user = JFactory::getUser();
       	$userFormat = array(
       		'user_name' => $user->username,
       		'user_id' => $user->id,
       		'is_login' => !$user->guest
       		);
       	$this->assignRef('user', $userFormat);

        /* 纪录开始时间 & 输出开始时间 */
        $startTime = time();
        $session -> set('start_time',$startTime);
        $this->assignRef('start_time', $startTime);
	}
}