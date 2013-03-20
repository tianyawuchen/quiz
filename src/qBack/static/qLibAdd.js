define(function(require, exports, module) {

	var $ = require('jquery');

	var qLibAdd = function() {
		$addInput = $("#quiz_lib_add_input");
		$addBtn = $("#quiz_lib_add_btn");

		$addBtn.click(function(e) {
			e.preventDefault();
			var unitTitle = $.trim($addInput.val());

			$.ajax({
				url:window.data.url.unit_add_url,
				type:'post',
				data:{
					'unit_title':unitTitle
				},
				success:function(response) {
					var resp = $.parseJSON(response);
					if(resp.status.code == 0) {
						location.reload();
					} else {
						alert(resp.status.msg);
					}
				}
			});
		});
	}

	module.exports = qLibAdd;
});