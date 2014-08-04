define([
    'app',
    'marionette',
    'text!./templates/layout.html.twig'
], function(App, Marionette, TplLayout){
    var SubNavbarView = {};

    SubNavbarView.Layout = Marionette.LayoutView.extend({
        template: TplLayout,
        className: 'subnavbar'
    });

    return SubNavbarView;
});