define(function(require, exports, module) {
	var $ = require('jquery');

	var qDelete = function() {
		var $history = $("#quiz_history");

		$history.on('click', '.quiz_history_delete', function(e) {
			e.preventDefault();
			var $ele = $(e.currentTarget);
			var hid = $ele.attr('hid');

			var isDel = confirm("请确定是否删除当前历史试卷？");

			if(isDel) {
				$.ajax({
					url:window.data.url.history_delete_url,
					type:'post',
					data:{'hid':hid},
					success:function(response) {
						var resp = $.parseJSON(response);
						if(resp.status.code == 0) {
							location.reload();
						} else {
							alert(resp.status.msg);
						}
					}
				});
			}
		})
	}

	module.exports = qDelete;
});