define(function(require, exports, module) {

	var $ = require('jquery');

	var CHANGE_TIME = 300;

	var qList = function() {
		var $qList = $("#quiz_list");

		var buildList = function(list) {
			var html = [];
			for(var i = 0; i < list.length; i++) {
				html.push('<a href="#" class="quiz_list_index" qid="'+list[i].qid+'" index="'+i+'">'+parseInt(i+1)+'</a>');
			}
			html = html.join("");
			$qList.append(html);
		};

		$qList.on('click', '.quiz_list_index', function(e) {
			e.preventDefault();
			var $ele = $(e.currentTarget);
			var index = $ele.attr('index');
			var qid = $ele.attr('qid');
			seajs.emit('set_qa', index);
		});

		seajs.on('show_result', function() {
			$qList.remove();//animate({'width':0,'opacity':0}, CHANGE_TIME);
		});
		seajs.on('set_qa_list', buildList);
		seajs.on('set_qa', function(index) {
			var $eleList = $qList.find('.quiz_list_index');
			var $ele = $eleList.get(index);
			$eleList.removeClass('quiz_list_now');
			$ele.removeClass().addClass('quiz_list_index').addClass('quiz_list_now');
		});
		seajs.on('set_result', function(obj) {
			var index = obj.index;
			var $ele = $qList.find('.quiz_list_index').get(index);
			$ele.removeClass().addClass('quiz_list_index').addClass('quiz_list_selected');
		});
	};

	module.exports = qList;
});