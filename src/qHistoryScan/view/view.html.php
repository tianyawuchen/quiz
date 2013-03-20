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

class QuizViewQHistoryScan extends JView {
	private $ajax = null;
	public $hid = 0;
	
	private $ERROR = array(
		
		);

	function inputFunc() {
		$this->ajax = JRequest::getVar('ajax');
		$this->hid = JRequest::getVar('hid');
	}

	function analizeFunc() {
		switch($this->ajax) {
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

	function showPage() {
		$model = $this->getModel();

		/* 输出用户信息 */
       	$user = JFactory::getUser();
       	$userFormat = array(
       		'user_name' => $user->username,
       		'user_id' => $user->id,
       		'is_login' => !$user->guest
       		);
       	$this->assignRef('user', $userFormat);

       	$hid = $this->hid;
       	$history = $model->getHistoryById($hid);
       	$score = $history->score;
       	$time = Date('Y-m-d H:i', $history->created + 8 * 60 * 60);
       	$qaList = json_decode($history->qa_list);

       	$qaFormatList = array();

       	foreach($qaList as $key => $value) {
       		$qa = array();
    		$qa['question'] = $model->getQuestionById($value->qid);
    		$qa['answer']   = $model->getAnswerListByQid($value->qid);
    		$qa['aid'] = $value->aid;
    		array_push($qaFormatList, $qa);
       	}

       	$this->assignRef('hid', $hid);
       	$this->assignRef('score', $score);
       	$this->assignRef('time', $time);
       	$this->assignRef('qa_list', $qaFormatList);
	}
}