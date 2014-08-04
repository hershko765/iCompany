define([
    'app',
    'marionette',
    './view'
], function(App, Marionette, TopBarView){
    var TopNavbarController;
    TopNavbarController = Marionette.Controller.extend({
        initialize: function(options) {
            var layout = new TopBarView.Layout();
            App.topBarRegion.show(layout);
        }
    });

    return TopNavbarController;
});