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
<link rel="stylesheet" href="<?echo QuizUtil::URL('assets', 'qBackList/style.css')?>">
<script>
	var data = {
		url:{
			base_url:"<?echo QuizUtil::URL('base');?>",
			list_add_url:"<?echo QuizUtil::URL('list_add')?>",
			list_delete_url:"<?echo QuizUtil::URL('list_delete')?>",
			list_modify_url:"<?echo QuizUtil::URL('list_modify')?>"
		},
		unit:<?echo json_encode($this->unit)?>
	}
</script>
<div id="quiz">
    <div class="quiz_title">
        <h2>quiz在线测试后台管理系统</h2>
        <a href="#" id="quiz_screenfull">全屏</a>
    </div>
    <div class="quiz_nav">
        <a href="<?echo QuizUtil::URL('back_page')?>">quiz题库管理</a>&gt;
        <a href="<?echo QuizUtil::URL('back_list_page', $this->unit ? ('unit='.$this->unit->unit_id) : "")?>"><?echo $this->unit->title?>题目列表</a>
    </div>
    <div class="quiz_back">
		<div class="quiz_back_operator">
			<a href="<?echo QuizUtil::URL('list_add_page', $this->unit ? ('unit='.$this->unit->unit_id) : "")?>">添加题目</a>
		</div>
		<div class="quiz_back_list" id="quiz_back_list">
		<?php
		if($this->qList) {
			$i = 0;
			foreach($this->qList as $key => $value) {
				$changeColor = $i++ % 2 ? "quiz_list_ele_A" : "quiz_list_ele_B";
		?>
			<div class="quiz_list_ele <?echo $changeColor?>">
				<span class="quiz_list_id"><?echo $value->q_id?></span>
				<a class="quiz_list_question" href="<?echo QuizUtil::URL('list_modify_page', 'qid='.$value->q_id)?>"><?echo $value->question?></a>
				<a class="quiz_list_delete" href="#" qid="<?echo $value->q_id?>">删除</a>
				<a class="quiz_list_modify" href="#">修改</a>
			</div>
		<?php
			}
		} else {
		?>
			<h3>本题库还未添加题目，请添加!</h3>
		<?
		}
		?>
		</div>
    </div>
</div>
<script src="<?echo QuizUtil::URL('seajs')?>" data-config="qBackList/config" data-main="qBackList/main"></script>