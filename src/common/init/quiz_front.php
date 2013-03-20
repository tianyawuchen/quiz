<?php
/**
 * @file quiz.php
 * @desc 程序初始化，启动controller
 * 
 * @author wangqi
 * @version 2013-03-06
 */
defined( '_JEXEC' ) or die( 'Restricted access' );

/* 引入controller */
require_once( JPATH_COMPONENT.DS.'controller.php' );
/* 引入工具类 */
require_once( JPATH_COMPONENT.DS.'helpers'.DS.'util.php' );
/* 引入ajax封装类 */
require_once( JPATH_COMPONENT.DS.'helpers'.DS.'ajax.php' );

/* 根据url param进行controller指定（本组件仅使用单一controllers进行路由分发） */
if ($controller = JRequest::getWord('controller')) {
	$path = JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php';
	if (file_exists($path)) {
		require_once $path;
	} else {
		$controller = '';
	}
}

/* 创建controller */
$classname	= 'QuizController'.$controller;
$controller	= new $classname();

/* 执行 */
$controller->execute( JRequest::getVar( 'task' ) );

/* 重定向 */
$controller->redirect();