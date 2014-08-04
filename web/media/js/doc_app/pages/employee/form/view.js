define([
    'app',
    'marionette',
    'text!./templates/layout.html.twig',
    'text!./templates/_form.html.twig'
], function(App, Marionette, TplLayout, TplForm){
    var EmployeeFormView = {};

    EmployeeFormView.Layout = Marionette.LayoutView.extend({
        template: TplLayout,
        regions: {
            formRegion: '#form-region'
        }
    });

    EmployeeFormView.FormView = Marionette.LayoutView.extend({
       template: TplForm,
        regions: {
            pwdRegion: '#pwd-region'
        }
    });

    return EmployeeFormView;
});