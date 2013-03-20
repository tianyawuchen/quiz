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

class QuizViewQBack extends JView {
	
	private $ajax = null;

	private $ERROR = array(
		'ADD_ERROR' => array('code' => 40001, 'msg' => '当前内容未插入，请重试'),
		'PARAM_EMPTY' => array('code' => 40002, 'msg' => '提交内容不能为空，请填写内容后重试'),
		'DELETE_ERROR' => array('code' => 40003, 'msg' => '当前内容删除失败，请重试'),
		'MODIFY_ERROR' => array('code' => 40004, 'msg' => '当前内容修改失败，请重试')
	);

	function inputFunc() {
		$this->ajax = JRequest::getVar('ajax');
	}

	function analizeFunc() {
		switch ($this->ajax) {
			case 'UNIT_ADD':
				$this->unitAdd();
				break;
			case 'UNIT_DELETE':
				$this->unitDelete();
				break;
			case 'UNIT_MODIFY':
				$this->unitModify();
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

	function unitAdd() {
		/* 提交数据获取并自动解析json格式 */
		$unit_title = JRequest::getVar('unit_title', NULL, 'post');

		if(!$unit_title) {
			$code = $this->ERROR['PARAM_EMPTY']['code'];
			$msg = $this->ERROR['PARAM_EMPTY']['msg'];
			$ajax = new QuizAjax(null, $code, $msg);
			$ajax->display();
			return;
		}

		$model = $this->getModel();

		$result = $model->addUnit($unit_title);

		if($result) {
			$ajax = new QuizAjax();
			$ajax->display();
		} else {
			$code = $this->ERROR['ADD_ERROR']['code'];
			$msg = $this->ERROR['ADD_ERROR']['msg'];
			$ajax = new QuizAjax(null, $code, $msg);
			$ajax->display();
		}
	}


	function unitDelete() {
		/* 提交数据获取并自动解析json格式 */
		$unit_id = JRequest::getVar('unit_id', NULL, 'post');

		$model = $this->getModel();

		$result = $model->deleteUnitById($unit_id);

		if($result) {
			$ajax = new QuizAjax();
			$ajax->display();
		} else {
			$code = $this->ERROR['DELETE_ERROR']['code'];
			$msg = $this->ERROR['DELETE_ERROR']['msg'];
			$ajax = new QuizAjax(null, $code, $msg);
			$ajax->display();
		}
	}

	function unitModify() {
		/* 提交数据获取并自动解析json格式 */
		$unit_id = JRequest::getVar('unit_id', NULL, 'post');
		$unit_title = JRequest::getVar('unit_title', NULL, 'post');

		$model = $this->getModel();

		$result = $model->updateUnitById($unit_id, $unit_title);

		if($result) {
			$ajax = new QuizAjax();
			$ajax->display();
		} else {
			$code = $this->ERROR['MODIFY_ERROR']['code'];
			$msg = $this->ERROR['MODIFY_ERROR']['msg'];
			$ajax = new QuizAjax(null, $code, $msg);
			$ajax->display();
		}
	}

	function showPage() {
		/* 拿到DAL层接口 */
		$model = $this->getModel();
		$session = &JFactory::getSession();

		$unitList = $model->getUnitList();
		$this->assignRef('unit_list', $unitList);

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