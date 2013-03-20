define(function(require, exports, module) {

	var $ = require("jquery");

	var qListDelete = function() {
		$qList = $("#quiz_back_list");

		$qList.on('click', '.quiz_list_delete', function(e) {
			e.preventDefault();
			var $ele = $(e.currentTarget);
			var qid = $ele.attr('qid');

			var isDel = confirm("请确认是否删除当前题目？");

			if(isDel) {
				$.ajax({
					url:window.data.url.list_delete_url,
					type:'post',
					data:{'qid':qid},
					success:function(response) {
						var resp = $.parseJSON(response);
						if(resp.status.code == 0) {
							location.reload();
						} else {
							alert(resp.status.msg);
						}
					}
				});
			} else {

			}
		});
	};

	module.exports = qListDelete;
});