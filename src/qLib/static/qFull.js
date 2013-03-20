define(function(require, exports, module) {
	var $ = require('jquery');
	var screenfull = require('screenfull');

	var full = function() {
		var $quiz = document.getElementById("quiz");
		var $fullBtn = $("#quiz_screenfull");

		$fullBtn.click(function(e) {
			e.preventDefault();
			screenfull.toggle($quiz);
		});
	};

	module.exports = full;
});