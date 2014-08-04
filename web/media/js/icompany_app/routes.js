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
		App.IcompanyRoutes = new Routes({});
		App.IcompanyRoutes.on('route', function(route, params){ });
	});

	return Routes;
});