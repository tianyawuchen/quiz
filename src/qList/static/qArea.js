define(function(require, exports, module){

	var $ = require('jquery');

	var SELARR = ['A','B','C','D','E','F','G','H','I',"J"];

	var qArea = function() {
		var $area = $("#quiz_area_wrap");
		var nowIndex = 0;
		var CHANGETIME = 300;

		var buildQA = function(qa, index) {
			var html = [];
			qindex = parseInt(index) + 1;
			nowIndex = index;
			html.push('<div class="quiz_area">');
			html.push('<div id="quiz_question_' + qa.q_id + '" class="quiz_area_question">');
            html.push('<span class="quiz_area_question_index">' + qindex + '</span>');
            html.push(qa.question);
            html.push('</div>');
            html.push('<div class="quiz_area_answer">');
            for(i = 0; i < qa.answer.length; i++) {
            	var curAnswer = qa.answer[i];
	            html.push('<div class="quiz_area_answer_ele ">');
	            html.push('<a aid="' + curAnswer.aid + '" index="'+index+'" class="quiz_answer_ele ');
	            if(qa.result && qa['result']['aid'] == curAnswer.aid) {
	            	html.push('quiz_selected');
	            }
	            html.push('" href="">' + SELARR[i] + '</a>' + curAnswer.answer + '</div>');
            }
            html.push('</div></div>');
            html = html.join("");
            $area.find('.quiz_area').fadeOut(CHANGETIME, function() {
            	$area.find('.quiz_area').remove();
            	$(html).appendTo($area).fadeOut(0).fadeIn(CHANGETIME);
            });
		}

		var buildResultCard = function(score, right) {
			var qa = DataCenter.getQAList();

			$area.css({"paddingRight":0,"marginRight":0});

			html = [];
			html.push('<div class="quiz_score_head">');
			html.push('<h2 class="quiz_score_title_b">成绩单</h2>');
	    	html.push('<h3 class="quiz_score_title_m">分数:<span class="quiz_score_num">'+score+'</span></h3>');
	    	html.push('<h3 class="quiz_score_title_m">错题解析：</h3>');
	    	html.push("</div>");
	    	html.push('<div class=:quiz_clear></div>');
	    	for (var i = 0, k = 0; i < right.length; i++) {
	    		var qele = qa[i];
	    		var aele = right[i];
	    		if(!aele.is_right) {
			    	html.push('<div class="quiz_result_err ');
			    	if(k%2) {
			    		html.push("quiz_result_bg_A");
			    	} else {
			    		html.push("quiz_result_bg_B");
			    	}
			    	k += 1;
			    	html.push('">');
			    	html.push('<h4 class="quiz_score_title_s">题干:</h4>');
			    	html.push('<p>'+qele.question+'</p>');
			    	html.push('<h4>正确答案:</h4>');
			    	html.push('<p>'+aele.right_answer.answer+'</p>');
			    	html.push('<h4>你的答案:</h4>');
			    	if(!aele.aid) {
			    		html.push('<p>未填</p>');
			    	} else {
			    		for(var j = 0; j < qele.answer.length; j++) {
			    			if(qele.answer[j].aid = aele.aid) {
			    				html.push('<p>'+qele.answer[j].answer+'</p>');
			    				break;
			    			}
			    		}
			    	}
			    	html.push('</div>');
	    		}
	    	}
	    	html = html.join('');

			$area.html(html);
		}

		$area.on('click', '.quiz_answer_ele', function(e) {
			e.preventDefault();
			var $ele = $(e.currentTarget);
			var index = $ele.attr("index");
			var aid = $ele.attr("aid");
			$area.find('.quiz_answer_ele').removeClass('quiz_selected');
			$ele.addClass('quiz_selected');

			seajs.emit('set_result', {index:index,aid:aid});
			/*setTimeout(function() {
				seajs.emit('set_next');
			}, CHANGETIME);*/
		});

		seajs.on('show_result', function(data) {
			buildResultCard(data.score, data.right_list);
		});
		seajs.on('set_qa_list', function(list) {
			var qa = list[0];
			buildQA(qa, 0);
		});
		seajs.on('set_qa', function(index) {
			var qa = DataCenter.getQA(index);
			buildQA(qa, index);
		});
		seajs.on('set_next', function() {
			var curIndex = (parseInt(nowIndex)+1)%DataCenter.getQASize()
			seajs.emit('set_qa', curIndex);
		});
	};

	module.exports = qArea;
});