/**
 * Login Controller
 */
define([
	'app',
	'marionette',
	'./view'
], function(App, Marionette, LoginView){
	var loginController = {};
	loginController = Marionette.Controller.extend({
		// Show Login
		initialize: function(){
			App.subNavbarRegion.close();
			var loginView = new LoginView.MainView();

			this.listenTo(loginView, 'user:login:clicked', function(){
				// Check Login
				// If success show tools toolbar
				App.vent.trigger('show:tools');
				App.Routes.navigate('#dashboard', {trigger:true});
			});

			App.mainRegion.show(loginView);
		}
	});

	return loginController;
});