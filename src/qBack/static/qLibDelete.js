define(function(require, exports, module) {

	var $ = require('jquery');

	var qLibDelete = function() {
		var $libList = $("#quiz_lib_list");

		$libList.on('click', '.quiz_lib_delete', function(e) {
			e.preventDefault();
			var $ele = $(e.currentTarget);
			var unit_id = $ele.attr('uid');

			var isDel = confirm("请确认是否删除当前单元？");

			if (isDel) {
				$.ajax({
					url:window.data.url.unit_delete_url,
					type:'post',
					data:{'unit_id':unit_id},
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
		});
	}

	module.exports = qLibDelete;
});