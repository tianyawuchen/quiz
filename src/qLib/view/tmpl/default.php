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
<link rel="stylesheet" href="<?echo QuizUtil::URL('assets', '/qLib/style.css')?>">
<script>
	var data = {
		url:{
			base_url:"<?echo QuizUtil::URL('base');?>",
			lib_url:"<?echo QuizUtil::URL('lib_page');?>"
		},
		user:<?echo json_encode($this->user)?>,
		unit:<?echo json_encode($this->unit_list)?>
	};
</script>
<div id="quiz">
    <div class="quiz_title">
        <h2>quiz在线测试系统</h2>
        <a href="#" id="quiz_screenfull">全屏</a>
    </div>
    <div class="quiz_nav">
        <a href="#">quiz首页</a>&gt;
        <a href="<?echo QuizUtil::URL('lib_page');?>">题库</a>
    </div>
    <div class="quiz_lib">
    	<h2>在线测试题库选择:</h2>
		<a class="quiz_link quiz_link_A" href="<?echo QuizUtil::URL('list_page');?>">
			综合在线测试卷
		</a>	
    <?php
    	$i = 0;
    	foreach($this->unit_list as $key => $value) {
    		$colorChange = $i++ % 2 ? 'quiz_link_A' : 'quiz_link_B';
    ?>
		<a class="quiz_link <?echo $colorChange?>" href="<?echo QuizUtil::URL('list_page','unit='.$value->unit_id);?>">
			<?echo $value->title.'在线测试卷';?>
		</a>	
    <?}?>
    </div>
<script src="<?echo QuizUtil::URL('seajs')?>" data-config="qLib/config" data-main="qLib/main"></script>