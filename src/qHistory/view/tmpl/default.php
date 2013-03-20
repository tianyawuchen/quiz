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
<link rel="stylesheet" href="<?echo QuizUtil::URL('assets', '/qHistory/style.css')?>">
<script>
	var data = {
		url:{
			base_url:"<?echo QuizUtil::URL('base');?>",
			history_delete_url:"<?echo QuizUtil::URL('history_delete');?>"
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
        <a href="<?echo QuizUtil::URL('history_page');?>">历史试卷</a>
    </div>
    <div class="quiz_history" id="quiz_history">
    	<?php 
    	$i = 0;
    	foreach ($this->qaList as $key => $value) {
    		$colorChange = $i++ % 2 ? 'quiz_link_A' : 'quiz_link_B';
    	?>
		<div class="quiz_history_ele">
			<a class="quiz_history_scan <?echo $colorChange;?>" href="<?echo QuizUtil::URL('history_scan', 'hid='.$value['h_id'])?>">
				<?echo $value['time'].'&nbsp;测试卷'?>
				<span class="quiz_history_score"><?echo '('.$value['score'].'分)'?></span>
			</a>
			<a href="#" class="quiz_history_delete <?echo $colorChange;?>" hid="<?echo $value['h_id']?>">删除</a>
		</div>
    	<?}?>

    </div>
<script src="<?echo QuizUtil::URL('seajs')?>" data-config="qHistory/config" data-main="qHistory/main"></script>