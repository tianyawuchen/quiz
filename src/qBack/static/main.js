define(function(require) {
	var qLibAdd = require('./qLibAdd');
	var qLibDelete = require('./qLibDelete');
	var qLibModify = require('./qLibModify');

	var libAdd = new qLibAdd();
	var libDelete = new qLibDelete();
	var libModify = new qLibModify();
	
	var qFull = require('./qFull');
	var full = new qFull();
});

