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
<link rel="stylesheet" href="<?echo QuizUtil::URL('assets', 'qBack/style.css')?>">
<script>
	var data = {
		url:{
			base_url:"<?echo QuizUtil::URL('base');?>",
			unit_add_url:"<?echo QuizUtil::URL('unit_add')?>",
			unit_delete_url:"<?echo QuizUtil::URL('unit_delete')?>",
			unit_modify_url:"<?echo QuizUtil::URL('unit_modify')?>"
		}
	}
</script>
<div id="quiz">
    <div class="quiz_title">
        <h2>quiz在线测试后台管理系统</h2>
        <a href="#" id="quiz_screenfull">全屏</a>
    </div>
    <div class="quiz_nav">
        <a href="<?echo QuizUtil::URL('back_page')?>">quiz题库管理</a>
    </div>
    <div class="quiz_back">
		<div class="quiz_back_operator">
			<input id="quiz_lib_add_input" type="text">
			<a id="quiz_lib_add_btn" href="#">-&gt;添加题库</a>
		</div>
		<div class="quiz_back_list" id="quiz_lib_list">
		<?php
		$i = 0;
		foreach($this->unit_list as $key => $value) {
			$libColorChange = $i++ % 2 ? 'quiz_lib_ele_A' : 'quiz_lib_ele_B';
		?>
			<div class="quiz_back_lib_ele <?echo $libColorChange?>">
				<a href="<?echo QuizUtil::URL('back_list_page', 'unit='.$value->unit_id)?>" class="quiz_lib_title"  uid="<?echo $value->unit_id?>"><?echo $value->title?></a>
				<input class="quiz_lib_input" type="text" value="<?echo $value->title?>">
				<a href="#" class="quiz_lib_submit" uid="<?echo $value->unit_id?>">提交</a>
				<a href="#" class="quiz_lib_delete" uid="<?echo $value->unit_id?>">删除</a>
				<a href="#" class="quiz_lib_modify" uid="<?echo $value->unit_id?>">修改</a>
			</div>
		<?}?>
		</div>
    </div>
</div>
<script src="<?echo QuizUtil::URL('seajs')?>" data-config="qBack/config" data-main="qBack/main"></script>