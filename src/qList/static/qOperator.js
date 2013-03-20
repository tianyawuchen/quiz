define(function(require, exports, module) {

	var $ = require('jquery');

	var qOperator = function() {
		var $next = $("#quiz_operator_next");
		var $submit = $("#quiz_operator_submit");
		var $giveup = $("#quiz_operator_giveup");

		$next.click(function(e) {
			e.preventDefault();
			seajs.emit('set_next');
		});
		$submit.click(function(e) {
			e.preventDefault();
			seajs.emit('list_submit');
		});
		$giveup.click(function(e) {
			e.preventDefault();
			location.href = window.data.url.base_url;
		});


		seajs.on('show_result', function() {
			$next.remove();
			$submit.remove();
			$giveup.remove();
		});
	};

	module.exports = qOperator;
});