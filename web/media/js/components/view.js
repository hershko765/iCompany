/**
 * Base View object
 */
define(['app', 'marionette'], function(App, Marionette){
	var View = {};
	var customView = {
		onBeforeRender: function(){
			var helpers = this.templateHelpers ? this.templateHelpers() : {};
			this.templateHelpers = function() {
				return $.extend(
					helpers, {
					userInfo: (function(){
						return App.request('get:active:user')
					}())
				});
			}
		}
	};

	// Extend all types of view
	View.Layout         = Marionette.Layout.extend(customView);
	View.ItemView       = Marionette.ItemView.extend(customView);
	View.CompositeView  = Marionette.CompositeView.extend(customView);
	View.CollectionView = Marionette.CollectionView.extend(customView);

	return View;
});