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
<link rel="stylesheet" href="<?echo QuizUtil::URL('assets', 'qListAdd/style.css')?>">
<script>
	var data = {
		url:{
			base_url:"<?echo QuizUtil::URL('base');?>",
			list_add_url:"<?echo QuizUtil::URL('list_add')?>",
			lib_url:"<?echo QuizUtil::URL('back_list_page', $this->unit ? ('unit='.$this->unit->unit_id) : "")?>"
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
        <a href="<?echo QuizUtil::URL('back_list_page', $this->unit ? ('unit='.$this->unit->unit_id) : "")?>"><?echo $this->unit->title?>题目列表</a>&gt;
        <a href="<?echo QuizUtil::URL('list_add_page', $this->unit ? ('unit='.$this->unit->unit_id) : "")?>">添加题目</a>
    </div>
    <div class="quiz_back">
		<div class="quiz_back_operator">
		<a href="#" id="quiz_submit">保存题目</a>
		</div>
		<div class="quiz_list_add" id="quiz_list_add">
		<fieldset>
			<legend>单元</legend>
			<div class="quiz_unit_area" id="quiz_unit_area" uid="<?echo $this->unit->unit_id?>">
			<?php
			foreach($this->unit_list as $key => $value) {
			?>
				<a href="#" class="quiz_unit_ele <?echo $this->unit->unit_id == $value->unit_id ? 'quiz_unit_selected':''?>" uid="<?echo $value->unit_id?>">
					<?echo $value->title?>
				</a>
			<?}?>
			</div>
		</fieldset>
		<fieldset>
			<legend>题干</legend>
			<textarea class="quiz_question_area" id="quiz_question_area"></textarea>
		</fieldset>
		<fieldset>
			<legend>答案&nbsp;&nbsp;&nbsp;&nbsp;(<a id="answer_add_btn" href="#">添加答案</a>)</legend>
			<div id="quiz_answer_area">
				<div class="quiz_answer_ele">
					<textarea class="quiz_answer_input"></textarea>
					<a href="#" class="quiz_answer_delete">删除</a>
					<a href="#" class="quiz_answer_right quiz_answer_true" is_right="1"></a>
				</div>
				<div class="quiz_answer_ele">
					<textarea class="quiz_answer_input"></textarea>
					<a href="#" class="quiz_answer_delete">删除</a>
					<a href="#" class="quiz_answer_right quiz_answer_false" is_right="0"></a>
				</div>
			</div>
		</fieldset>
		</div>
    </div>
</div>
<script src="<?echo QuizUtil::URL('seajs')?>" data-config="qListAdd/config" data-main="qListAdd/main"></script>