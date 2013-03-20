/**
 * @file qDataCenter
 *
 * @desc 答题页数据中心，对数据进行统一操作
 *
 * @author wangqi05
 * @version 2013-03-05
 */
define(function(require, exports, module){
	var qDataCenter = function() {
		/* define */
		var qaList = null;
		var _getQA = function(index) {
			return qaList[index];
		};
		var _getQAList = function() {
			return qaList;
		};
		var _getQASize = function() {
			return qaList.length;
		};
		var _setQAList = function(list) {
			qaList = list;
			for(var i = 0; i < qaList.length; i++) {
				qaList[i].result = { qid:qaList[i].qid }
			}
			seajs.emit('set_qa_list', list);
		};

		/* listen */
		seajs.on('set_result', function(obj) {
			var index = obj.index;
			var aid = obj.aid;
			qaList[index].result = {
				qid: qaList[index].qid,
				aid: aid
			};
		});

		seajs.on('list_submit', function() {
			var result = [];
			for(var i = 0; i < qaList.length; i++) {
				var cur = qaList[i].result;
				result[i] = cur;
			}
			
			$.ajax({
				url : window.data.url.submit_url,
				type:"post",
				data:{'result':result},
				success: function(response) {
					var resp = $.parseJSON(response);
					if(resp.status.code == 0) {
						seajs.emit('show_result', resp.data);
					} else {
						alert(resp.status.msg);
					}
				}
			});
		});

		/* init */

		_setQAList(window.data.qa_list);

		/* return */
		return {
			getQA : _getQA,
			getQAList : _getQAList,
			getQASize : _getQASize,
			setQAList : _setQAList
		};
	};

	module.exports = qDataCenter;
});