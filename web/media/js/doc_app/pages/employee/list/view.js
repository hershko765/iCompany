define([
    'app',
    'marionette',
    'text!./templates/layout.html.twig'
], function(App, Marionette, TplLayout){
    var EmployeeListView = {};

    EmployeeListView.Layout = Marionette.LayoutView.extend({
        template: TplLayout,
        regions: {
            titleRegion: '#title-region',
            gridRegion: '#grid-region'
        }
    });

    return EmployeeListView;
});