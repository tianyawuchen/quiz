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
		$base    = JURI::base(true)."/";
		$baseUrl = $base."index.php?option=com_quiz";
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
			case 'history_delete':
				$fullUrl = $baseUrl.'&view=qHistory&ajax=HISTORY_DELETE&'.$postfix;
				break;
			case 'history_scan':
				$fullUrl = $baseUrl.'&view=qHistoryScan&'.$postfix;
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