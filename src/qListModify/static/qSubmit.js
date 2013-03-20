define(function(require, exports, module) {

	var $ = require('jquery');

	var qSubmit = function() {
		var $submit = $("#quiz_submit");

		var $unit = $("#quiz_unit_area");
		var $question = $("#quiz_question_area");

		$submit.click(function(e) {
			e.preventDefault();

			var check = true;

			var $answerList = $(".quiz_answer_ele");
			var $answerDelList = $('.quiz_delete_answer');

			var unit_id  = $unit.attr("uid");

			var qid = $question.attr('qid');
			var question = $.trim($question.val());

			/* 题目信息校验 */
			if(!qid) {
				check = false;
				alert("当前题目不存在!");
				return;
			}

			if(!question) {
				check = false;
				alert("题干不能为空!");
				return;
			}

			var answerList = [];

			/* 答案信息格式化与校验 */
			$answerList.each(function(index, ele) {
				var $ele = $(ele);
				var $input = $ele.find(".quiz_answer_input");
				var $right = $ele.find(".quiz_answer_right");

				var aid = $input.attr('aid');
				var answer = $.trim($input.val());
				var is_right = $right.attr('is_right');

				if(!answer) {
					check = false;
					alert("第" + parseInt(index+1) + "个答案为空，请填写内容!");
					return;
				}

				answerList.push({
					'aid':aid,
					'answer':answer,
					'is_right':is_right,
					'is_del':0
				});
			});

			/* 删除答案格式化与校验 */
			$answerDelList.each(function(index, ele) {
				var $ele = $(ele);
				var aid = $ele.attr('aid');

				if(aid) {
					answerList.push({
						'aid':aid,
						'answer':'',
						'is_right':0,
						'is_del':1
					});
				}
			});

			console.log({
				'unit_id':unit_id,
				'qid':qid,
				'question':question,
				'answer_list':answerList
			});

			if(check) {
				$.ajax({
					url:window.data.url.list_modify_url,
					type:'post',
					data:{
						'unit_id':unit_id,
						'qid':qid,
						'question':question,
						'answer_list':answerList
					},
					success:function(response) {
						var resp = $.parseJSON(response);
						if(resp.status.code == 0) {
							location.href = window.data.url.lib_url;
						} else {
							alert(resp.status.msg);
						}
					}
				});
			}
		});

	};

	module.exports = qSubmit;
});