define([
    'app',
    'marionette',
    'backbone',
    'text!./templates/layout.html.twig'
], function(App, Marionette, Backbone, TplLayout){
    var TopNavbarView = {};
    TopNavbarView.Layout = Marionette.LayoutView.extend({
        template: TplLayout,
        tagName: 'nav',
        className: 'navbar navbar-inverse',
        attributes: {
            role: 'navigation'
        }
    });

    return TopNavbarView;
});