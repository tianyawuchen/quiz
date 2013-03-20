<?php
/**
 *
 *
 *
 */
class QuizUtil {
	/**
	 * 获取用户登录状态
	 * 
	 * @gram quizUtil::checkUserPower()
	 * @return boolean (false为未登录，true为登录)
	 */
	public static function checkUserPower() {
		$user = JFactory::getUser();
		return !$user->guest;
	}

	public static function URL($url = 'base', $postfix = '') {
		$base    = JURI::root(true)."/";
		$baseUrl = $base."index.php?option=com_quiz";
		$admin   = $base."administrator/";
		$adminUrl= $admin."index.php?option=com_quiz";
		$fullUrl = "";

		switch ($url) {
			/* 组件基本url */
			case 'base':
				$fullUrl = $baseUrl.$postfix;
				break;

			/* 题库页 */
			case 'lib_page':
				$fullUrl = $baseUrl.'&view=qLib&'.$postfix;
				break;

			/* 答题页及请求 */
			case 'list_page':
				$fullUrl = $baseUrl.'&view=qList&'.$postfix;
				break;
			case 'list_ajax_start':
				$fullUrl = $baseUrl.'&view=qList&ajax=AJAX_START&'.$postfix;
				break;
			case 'list_ajax_current':
				$fullUrl = $baseUrl.'&view=qList&ajax=AJAX_CURRENT&'.$postfix;
				break;
			case 'list_ajax_submit':
				$fullUrl = $baseUrl.'&view=qList&ajax=AJAX_SUBMIT&'.$postfix;
				break;

			/* 历史页 */
			case 'history_page':
				$fullUrl = $baseUrl.'&view=qHistory&'.$postfix;
				break;

			/* 后台管理-单元管理 */
			case 'back_page':
				$fullUrl = $adminUrl.'&view=qBack&'.$postfix;
				break;
			case 'unit_add':
				$fullUrl = $adminUrl.'&view=qBack&ajax=UNIT_ADD&'.$postfix;
				break;
			case 'unit_delete':
				$fullUrl = $adminUrl.'&view=qBack&ajax=UNIT_DELETE&'.$postfix;
				break;
			case 'unit_modify':
				$fullUrl = $adminUrl.'&view=qBack&ajax=UNIT_MODIFY&'.$postfix;
				break;

			case 'back_list_page':
				$fullUrl = $adminUrl.'&view=qBackList&'.$postfix;
				break;
			case 'list_delete':
				$fullUrl = $adminUrl.'&view=qBackList&ajax=LIST_DELETE&'.$postfix;
				break;

			case 'list_add_page':
				$fullUrl = $adminUrl.'&view=qListAdd&'.$postfix;
				break;
			case 'list_add':
				$fullUrl = $adminUrl.'&view=qListAdd&ajax=LIST_ADD&'.$postfix;
				break;

			case 'list_modify_page':
				$fullUrl = $adminUrl.'&view=qListModify&'.$postfix;
				break;
			case 'list_modify':
				$fullUrl = $adminUrl.'&view=qListModify&ajax=LIST_MODIFY&'.$postfix;
				break;

			/* media中resource地址 */
			case 'assets':
				$fullUrl = $base.'media/com_quiz/assets/'.$postfix;
				break;
			case 'seajs':
				$fullUrl = $base.'media/com_quiz/assets/seajs/sea.js'.$postfix;
				break;
			
			default:
				$fullUrl = $baseUrl.'&'.$postfix;
				break;
		}

		return $fullUrl;
	}
}