/**
 * Login View
 */
define([
	'app',
	'marionette',
	'components/view',
	'text!./templates/layout.twig'
], function(App, Marionette, View, tplLayout){

	var loginViews = {};
	loginViews.MainView = View.Layout.extend({
		template: tplLayout,
		events: {
			'click #login-form': function(e) {
				this.trigger('user:login:clicked');
				e.preventDefault();
			}
		}
	});

	return loginViews;
});