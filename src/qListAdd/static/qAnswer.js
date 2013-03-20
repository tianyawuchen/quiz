define(function(require, exports, module) {

	var $ = require("jquery");

	var qAnswer = function() {
		$answerArea = $("#quiz_answer_area");
		$answerAdd = $("#answer_add_btn");

		var answerAddInput = function() {
			var html = [
				'<div class="quiz_answer_ele">',
				'<textarea class="quiz_answer_input"></textarea>',
				'<a href="#" class="quiz_answer_delete">删除</a>',
				'<a href="#" class="quiz_answer_right quiz_answer_false" is_right="0"></a>',
				'</div>'
			];
			html = html.join("");
			$(html).appendTo($answerArea);
		}

		$answerAdd.click(function(e) {
			e.preventDefault();
			var len = $answerArea.find(".quiz_answer_delete").length;
			if(len < 10) {
				answerAddInput();
			} else {
				alert("至多能够编辑十个答案！");
			}
		});

		$answerArea.on('click', '.quiz_answer_delete', function(e) {
			e.preventDefault();
			var len = $answerArea.find(".quiz_answer_delete").length;
			if(len > 2) {
				var $ele = $(e.currentTarget);
				var $parent = $ele.parent();
				var $rightBtn = $parent.find('.quiz_answer_right');
				if($rightBtn.attr('is_right') == 1) {
					$parent.remove();
					var $rightList = $('.quiz_answer_right');
					$($rightList.get(0)).attr('is_right', 1).removeClass('quiz_answer_false').addClass('quiz_answer_true');
				} else {
					$parent.remove();
				}
			} else {
				alert("至少需要编辑两个答案！");
			}
		});

		$answerArea.on('click', '.quiz_answer_right', function(e) {
			e.preventDefault();
			var $ele = $(e.currentTarget);
			var $answerList = $('.quiz_answer_right');

			$answerList.attr('is_right', 0).removeClass('quiz_answer_true').addClass('quiz_answer_false');
			$ele.attr('is_right', 1).removeClass('quiz_answer_false').addClass('quiz_answer_true');


		});
	};

	module.exports = qAnswer;
});