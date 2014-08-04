define([
    'app',
    'marionette',
    './view'
], function(App, Marionette, SubNavbarView){
    var SubNavbarController;
    SubNavbarController = Marionette.Controller.extend({
        initialize: function(options) {
            var layout = new SubNavbarView.Layout();
            App.subNavbarRegion.show(layout);
        }
    });

    return SubNavbarController;
});