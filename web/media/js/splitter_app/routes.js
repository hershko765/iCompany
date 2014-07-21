define([
	'app',
	'backbone'
], function(App, Backbone){
	var Routes = Backbone.Router.extend({
		routes: {
			'': 'showDashboard'
		},
		showDashboard: function(){
			require(['splitter_app/dashboard/dashboard_app'],function(){
				App.execute('show:dashboard');
			});
		}
	});

	
	App.addInitializer(function () {
		App.Routes = new Routes({});
		App.Routes.on('route', function(route, params){ });
	});
	
	App.on('initialize:after', function () {
		App.getCurrentRoute = function(){
			return Backbone.history.fragment
		};

		if (Backbone.history) {
			Backbone.history.start();
		}
	});

	return Routes;
});