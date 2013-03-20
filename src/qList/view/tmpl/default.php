<?php 
/**
 * @package views/tmpl/default.php
 * @desc 答题页
 *
 * @author wangqi
 * @version 2013-03-07
 */
defined('_JEXEC') or die('Restricted access'); 
?>
<link rel="stylesheet" href="<?echo QuizUtil::URL('assets', '/qList/style.css')?>">
<script>
	var data = {
		url:{
			base_url:"<?echo QuizUtil::URL('base');?>",
			start_url:"<?echo QuizUtil::URL('list_ajax_start');?>",
			current_url:"<?echo QuizUtil::URL('list_ajax_current');?>",
			submit_url:"<?echo QuizUtil::URL('list_ajax_submit');?>"
		},
		qa_list:<?echo json_encode($this->qa_list)?>,
		user:<?echo json_encode($this->user)?>,
		time:{
			start_time:<?echo json_encode($this->start_time)?>
		}
	}
</script>
<div id="quiz">
    <div class="quiz_title">
        <h2>quiz在线测试系统</h2>
        <a href="#" id="quiz_screenfull">全屏</a>
    </div>
    <div class="quiz_nav">
        <a href="#">quiz首页</a>&gt;
        <a href="<?echo QuizUtil::URL('lib_page');?>">题库</a>&gt;
        <a href="<?echo QuizUtil::URL('list_page')?>">测试卷</a>
        <div class="quiz_time"><span>剩余时间:&nbsp;</span><span id="quiz_time">1:40:15</span>
        </div>
    </div>
    <div id="quiz_area_wrap">
        <div class="quiz_area" index="">
            
        </div>
    </div>
    <div id="quiz_list">
    	
    </div>
    <div class="quiz_clear"></div>
    <div class="quiz_operator">
        <a href="#" id="quiz_operator_next">下题</a>
        <a href="#" id="quiz_operator_submit">提交</a>
        <a href="#" id="quiz_operator_giveup">放弃</a>
    </div>
</div>
<script src="<?echo QuizUtil::URL('seajs')?>" data-config="qList/config" data-main="qList/main"></script>