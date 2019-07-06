yepnope([{
	load: [
		'/js/jquery.js',
		'/js/jquery-ui.min.js',
		'/js/jquery.tools.min.js',
		'/js/jquery.desaturate.js',
		'/js/toolbox.flashembed.js',
		'/js/jqtransformplugin/jquery.jqtransform.js',
		'/js/jquery.cookie.js'
	],
	complete: function() {
		yepnope([
			'/js/jquery.tabs.js',
//			'/js/comments/jquery.comments.js', // В продакшне не нужно
			'/js/scripts22.js'
		]);
	}
}]);