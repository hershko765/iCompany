/**
 * Main Login App file
 */
define(['app', 'splitter_app/login/controller'], function(App, loginController){

	var loginApp = {};
	loginApp.showLogin = function(options){
		return new loginController(options);
	};

	App.commands.setHandler('show:login', function(options){
		loginApp.showLogin(options);
	});

	return loginApp;
});