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

class QuizViewQBackList extends JView {
	
	private $ajax = null;
	private $unit_id = 0;

	private $ERROR = array(
		'Q_DELETE_ERROR' => array('code' => 40005, 'msg' => '当前内容删除失败，请重试')
	);

	function inputFunc() {
		$this->ajax = JRequest::getVar('ajax');
		$this->unit_id = JRequest::getVar('unit');
	}

	function analizeFunc() {
		switch ($this->ajax) {
			case 'LIST_DELETE':
				$this->questionDelete();
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

	function questionDelete() {
		$qid = JRequest::getVar('qid', NULL, 'post');

		$model = $this->getModel();

		$result = $model->deleteAnswerByQid($qid);
		$result &= $model->deleteQuestionById($qid);
		if($result) {
			$ajax = new QuizAjax();
			$ajax->display();
		} else {
			$code = $this->ERROR['Q_DELETE_ERROR']['code'];
			$msg  = $this->ERROR['Q_DELETE_ERROR']['msg'];
			$ajax = new QuizAjax($result, $code, $msg);
			$ajax->display();
		}
	}

	function showPage() {
		/* 拿到DAL层接口 */
		$model = $this->getModel();
		$session = &JFactory::getSession();

		/* 输出题目数据 */
		$unit = $model->getUnitById($this->unit_id);
		if(!!$unit) {
			$qList = $model->getQuestionByUnit($this->unit_id);
		} else {
			$qList = $model->getQuestionList();
		}
        $this->assignRef('unit', $unit);
        $this->assignRef('qList', $qList);

        /* 输出用户信息 */
       	$user = JFactory::getUser();
       	$userFormat = array(
       		'user_name' => $user->username,
       		'user_id' => $user->id,
       		'is_login' => !$user->guest
       		);
       	$this->assignRef('user', $userFormat);
	}
}