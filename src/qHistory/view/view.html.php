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

class QuizViewQHistory extends JView {
	private $ajax = null;
	
	private $ERROR = array(
		'HISTORY_DELETE_FAILED' => array('code' => 30005, 'msg' => '当前历史试卷删除失败，请重试！')
	);

	function inputFunc() {
		$this->ajax = JRequest::getVar('ajax');
	}

	function analizeFunc() {
		switch($this->ajax) {
			case 'HISTORY_DELETE':
				$this->historyDelete();
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

	function historyDelete() {
		$model = $this->getModel();

		$hid = JRequest::getVar('hid', null, 'post');

		$result = $model->deleteHistoryById($hid);

		if($result) {
			$ajax = new QuizAjax();
			$ajax->display();
		} else {
			$code = $this->ERROR['HISTORY_DELETE_FAILED']['code'];
			$msg  = $this->ERROR['HISTORY_DELETE_FAILED']['msg'];
			$ajax = new QuizAjax(null, $code, $msg);
			$ajax->display();
		}
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

       	$qaList = $model->getHistoryListByUid($user->id);
       	$qaFormatList = array();

       	foreach ($qaList as $key => $value) {
       		$qa = array();
       		$qa['h_id'] = $value->h_id;
       		$qa['score'] = $value->score;
       		$qa['time'] = Date('Y-m-d H:i', $value->created+8*60*60);

       		array_push($qaFormatList, $qa);
       	}
       	$this->assignRef('qaList', $qaFormatList);
	}
}