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

class QuizViewQListModify extends JView {
	
	private $ajax = null;
	private $qid = 0;
	private $unit_id = 0;

	private $ERROR = array(
		'Q_MODIFY_ERROR' => array('code' => 40008, 'msg' => '当前题目修改失败，请重试！')
	);

	function inputFunc() {
		$this->ajax = JRequest::getVar('ajax');
		$this->qid = JRequest::getVar('qid');
	}

	function analizeFunc() {
		switch ($this->ajax) {
			case 'LIST_MODIFY':
				$this->questionModify();
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

	function questionModify() {
		$unit_id = JRequest::getVar('unit_id', NULL, 'post');
		$qid = JRequest::getVar('qid', NULL, 'post');
		$question = JRequest::getVar('question', NULL, 'post');
		$answer_list = JRequest::getVar('answer_list', NULL, 'post');

		$model = $this->getModel();
		$result = true;

		$result &= $model->updateQuestionById($qid, nl2br($question), $unit_id);

		if($result) {
			foreach ($answer_list as $key => $value) {
				if(!$value['is_del']) {
					if(!$value['aid']) {
						$result &= $model->addAnswer(nl2br($value['answer']), $qid, $value['is_right']);
					} else {
						$result &= $model->updateAnswerById($value['aid'], nl2br($value['answer']), $value['is_right']);
					}
				} else {
					$result &= $model->deleteAnswerById($value['aid']);
				}
			}
			$ajax = new QuizAjax();
			$ajax->display();
		} else {
			$code = $this->ERROR['Q_MODIFY_ERROR']['code'];
			$msg  = $this->ERROR['Q_MODIFY_ERROR']['msg'];
			$ajax = new QuizAjax(null, $code, $msg);
			$ajax->display();
		}
	}

	function showPage() {
		/* 拿到DAL层接口 */
		$model = $this->getModel();

		/* 输出题目数据 */
		$question = $model->getQuestionById($this->qid);
		$answer_list = $model->getAnswerListByQid($this->qid);
		if($question) {
			$unit = $model->getUnitById($question->unit_id);
		} else {
			/* 跳到添加页面 */
		}
		$unit_list = $model->getUnitList();

		$this->assignRef('question', $question);
		$this->assignRef('answer_list', $answer_list);
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