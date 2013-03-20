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
<link rel="stylesheet" href="<?echo QuizUtil::URL('assets', '/qHistoryScan/style.css')?>">
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
        <a href="<?echo QuizUtil::URL('history_page');?>">历史试卷</a>&gt;
        <a href="<?echo QuizUtil::URL('history_scan', 'hid='.$this->hid);?>"><?echo $this->time?>&nbsp;历史试卷浏览</a>
    </div>
    <div class="quiz_history" id="quiz_history">
        <div class="quiz_score_head">
            <h2 class="quiz_score_title_b">成绩单</h2>
            <h3 class="quiz_score_title_m">分数:<span class="quiz_score_num"><?echo $this->score?></span></h3>
            <h3 class="quiz_score_title_m">错题解析：</h3>
        </div>
        <div class=:quiz_clear></div>
            <?php
            $i = 0;
            foreach($this->qa_list as $key => $value) {
                $colorChange = $i++ % 2 ? 'quiz_result_bg_A' : 'quiz_result_bg_B';
                $right = null;
                $answer = null;
                $is_right = false;
                foreach($value['answer'] as $k => $v) {
                    if($v->a_id == $value['aid']) {
                        $answer = $v;
                    }
                    if($v->is_right) {
                        $right = $v;
                    }
                    if($v->is_right && $v->a_id == $value['aid']) {
                        $is_right = true;
                    }
                }
            ?>
                <div class="quiz_result_err <?echo $colorChange?>">
                    <h4 class="quiz_score_title_s">题干:</h4>
                    <p><?echo $value['question']->question?></p>
                    <?if(!$is_right) {?>
                        <div class="quiz_result_noright">回答<br/>错误</div>
                        <h4>正确答案:</h4>
                        <p><?echo $right->answer?></p>
                        <h4>你的答案:</h4>
                        <?if(!$value['aid']) {?>
                            <p>未填</p>
                        <?} else {?>
                            <p><?echo $answer->answer?></p>
                        <?}?>
                    <?} else {?>
                        <div class="quiz_result_right">回答<br/>正确</div>
                        <h4>答案：</h4>
                        <p><?echo $right->answer?></p>
                    <?}?>
                </div>
            <?}?>
    </div>
<script src="<?echo QuizUtil::URL('seajs')?>" data-config="qHistoryScan/config" data-main="qHistoryScan/main"></script>