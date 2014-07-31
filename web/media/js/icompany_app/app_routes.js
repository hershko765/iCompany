define([
	'app',
	'backbone'
], function(App, Backbone){
    // define route
    var Routes = Backbone.Marionette.AppRouter.extend({
        // map path to function
        routes : {
            'home' : 'goHome'
        },
        goHome: function(){
            console.log('home!');
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