define(function(require) {
	var qUnit = require('./qUnit');
	var qQuestion = require('./qQuestion');
	var qAnswer = require('./qAnswer');
	var qSubmit = require('./qSubmit');

	var unit = new qUnit();
	var question = new qQuestion();
	var answer = new qAnswer();
	var submit = new qSubmit();
	
	var qFull = require('./qFull');
	var full = new qFull();
});

