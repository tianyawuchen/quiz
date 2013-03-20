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
<link rel="stylesheet" href="<?echo QuizUtil::URL('assets', 'qListModify/style.css')?>">
<script>
	var data = {
		url:{
			base_url:"<?echo QuizUtil::URL('base');?>",
			list_modify_url:"<?echo QuizUtil::URL('list_modify')?>",
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
        <a href="<?echo QuizUtil::URL('list_modify_page', 'qid='.$this->question->q_id)?>">修改题目</a>
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
			<textarea class="quiz_question_area" id="quiz_question_area" qid="<?echo $this->question->q_id?>"><?echo $this->question->question?></textarea>
		</fieldset>
		<fieldset>
			<legend>答案&nbsp;&nbsp;&nbsp;&nbsp;(<a id="answer_add_btn" href="#">添加答案</a>)</legend>
			<div id="quiz_answer_area">
				<?php
				foreach($this->answer_list as $key => $value) {
					$torf = $value->is_right ? 'quiz_answer_true' : 'quiz_answer_false';
				?>
				<div class="quiz_answer_ele">
					<textarea class="quiz_answer_input" aid="<?echo $value->a_id?>"><?echo $value->answer?></textarea>
					<a href="#" class="quiz_answer_delete" aid="<?echo $value->a_id?>">删除</a>
					<a href="#" class="quiz_answer_right <?echo $torf?>" is_right="<?echo $value->is_right?>"></a>
				</div>
				<?}?>
			</div>
		</fieldset>
		</div>
    </div>
</div>
<script src="<?echo QuizUtil::URL('seajs')?>" data-config="qListModify/config" data-main="qListModify/main"></script>