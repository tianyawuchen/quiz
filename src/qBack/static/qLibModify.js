define(function(require, exports, module) {

	var $ = require('jquery');

	var qLibModify = function() {
		var $libEleList = $(".quiz_back_lib_ele");
		var $allInput = $(".quiz_lib_input");
		var $allSubmit= $(".quiz_lib_submit");

		$libEleList.on('click', '.quiz_lib_modify', function(e) {
			e.preventDefault();
			var $ele = $(e.delegateTarget);
			var $input = $ele.find('.quiz_lib_input');
			var $submit = $ele.find('.quiz_lib_submit');

			if($input.css("display") == "none") {
				$allInput.css({"display":"none"});
				$allSubmit.css({"display":"none"});
				$input.css({"display":"block"});
				$submit.css({"display":"block"});
			} else {
				$input.css({"display":"none"});
				$submit.css({"display":"none"});
			}
		});

		$libEleList.on('click', '.quiz_lib_submit', function(e) {
			e.preventDefault();
			var $ele = $(e.delegateTarget);
			var $submit = $(e.currentTarget);
			var $input = $ele.find('.quiz_lib_input');

			var unit_id = $submit.attr('uid');
			var unit_title = $input.val();

			$.ajax({
				url:window.data.url.unit_modify_url,
				type:'post',
				data:{
					'unit_id':unit_id,
					'unit_title':unit_title
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

		})
	};

	module.exports = qLibModify;
});