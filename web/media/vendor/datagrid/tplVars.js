/**
 * Create template helpers variable from
 * a given config
 */
define([], function(){

	var tplVars = {};
	tplVars.containerVars = function(options) {
		var headers = [];
		$.each((options.headers || []), function(idx, val){
			headers.push({
				name:  val[0],
				title: val[1],
				width: val[2]
			});
		});

		return {
			headers: headers
		};
	};

	tplVars.rawData = function(obj) {

	};

	return tplVars;
});