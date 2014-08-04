define([
    'app',
    'marionette',
    'text!./templates/layout.html.twig'
], function(App, Marionette, TplLayout){
    var DashboardView = {};

    DashboardView.Layout = Marionette.LayoutView.extend({
        template: TplLayout
    });

    return DashboardView;
});