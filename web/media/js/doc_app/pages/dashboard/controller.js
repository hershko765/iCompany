define([
    'app',
    'marionette',
    './view'
], function(App, Marionette, View){
    var DashboardController;
    DashboardController = Marionette.Controller.extend({
        initialize: function(options) {
            var layout = new View.Layout();

            App.pageContentRegion.show(layout);
        }
    });

    return DashboardController;
});