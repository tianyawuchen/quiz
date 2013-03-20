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

			var unit_id  = $unit.attr("uid");

			var question = $.trim($question.val());
			if(!question) {
				check = false;
				alert("题干不能为空!");
				return;
			}

			var answerList = [];
			$answerList.each(function(index, ele) {
				var $ele = $(ele);
				var $input = $ele.find(".quiz_answer_input");
				var $right = $ele.find(".quiz_answer_right");

				var answer = $.trim($input.val());
				var is_right = $right.attr('is_right');
				if(!answer) {
					check = false;
					alert("第" + parseInt(index+1) + "个答案为空，请填写内容!");
					return;
				}
				answerList.push({
					'answer':answer,
					'is_right':is_right
				});
			});

			if(check) {
				$.ajax({
					url:window.data.url.list_add_url,
					type:'post',
					data:{
						'unit_id' : unit_id,
						'question': question,
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