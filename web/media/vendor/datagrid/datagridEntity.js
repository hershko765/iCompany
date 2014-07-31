define(['app', 'backbone'], function(App, Backbone){
	var DataGrid = {};
	DataGrid.createEntity = function(config) {

		DataGrid.Model = Backbone.Model.extend({
			urlRoot: config.url
		});

		DataGrid.Collection = Backbone.Collection.extend({
			url: config.url,
			model: DataGrid.Model,
			fetchList: function(options, callback){
				this.fetch({
					success: function(collection, response){
						if (callback) { callback(collection, response) }
					},
					data: options
				});
			}
		});

		return DataGrid;
	};

	return DataGrid;
});