define(function(require) {
	var qArea = require('./qArea');
	var qList = require('./qList');
	var qOperator = require('./qOperator');
	var qDataCenter = require('./qDataCenter');
	
	var Area = new qArea();
	var List = new qList();
	var Operator = new qOperator();
	window.DataCenter = new qDataCenter();
	
	var qFull = require('./qFull');
	var full = new qFull();
});

