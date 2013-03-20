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

class QuizViewQListAdd extends JView {
	
	private $ajax = null;
	private $qid = 0;
	private $unit_id = 0;

	private $ERROR = array(
		'Q_ADD_ERROR' => array('code' => 40006, 'msg' => '当前题目未插入，请重试'),
		'A_ADD_ERROR' => array('code' => 40007, 'msg' => '当前答案未插入，请重试')
	);

	function inputFunc() {
		$this->ajax = JRequest::getVar('ajax');
		$this->qid = JRequest::getVar('qid');
		$this->unit_id = JRequest::getVar('unit');
	}

	function analizeFunc() {
		switch ($this->ajax) {
			case 'LIST_ADD':
				$this->questionAdd();
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

	function questionAdd() {
		$unit_id = JRequest::getVar('unit_id', NULL, 'post');
		$question = JRequest::getVar('question', NULL, 'post');
		$answer_list = JRequest::getVar('answer_list', NULL, 'post');

		$model = $this->getModel();
		$result = true;

		$qid = $model->addQuestion(nl2br($question), $unit_id);
		if($qid) {
			foreach ($answer_list as $key => $value) {
				$result &= $model->addAnswer(nl2br($value['answer']), $qid, $value['is_right']);
			}

			if ($result) {
				$ajax = new QuizAjax();
				$ajax->display();
			} else {
				$code = $this->ERROR['A_ADD_ERROR']['code'];
				$msg  = $this->ERROR['A_ADD_ERROR']['msg'];
				$ajax = new QuizAjax(null, $code, $msg);
				$ajax->display();
			}
		} else {
			$code = $this->ERROR['Q_ADD_ERROR']['code'];
			$msg  = $this->ERROR['Q_ADD_ERROR']['msg'];
			$ajax = new QuizAjax(null, $code, $msg);
			$ajax->display();
		}
	}

	function showPage() {
		/* 拿到DAL层接口 */
		$model = $this->getModel();

		/* 输出题目数据 */
		$unit = $model->getUnitById($this->unit_id);
		$unit_list = $model->getUnitList();
        $this->assignRef('unit', $unit);
        $this->assignRef('unit_list', $unit_list);

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