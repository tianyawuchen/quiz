define(function(require, exports, module) {

	var $ = require('jquery');

	var qUnit = function() {
		$unitArea = $("#quiz_unit_area");
		uid = 0;

		$unitArea.on('click', '.quiz_unit_ele', function(e) {
			e.preventDefault();

			$unitEleList = $(".quiz_unit_ele");
			$ele = $(e.currentTarget);
			
			$unitEleList.removeClass('quiz_unit_selected');
			$ele.addClass('quiz_unit_selected');

			$unitArea.attr('uid', $ele.attr('uid'));
		});
	};

	module.exports = qUnit;
});