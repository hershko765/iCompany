/**
 * Top Navbar Application
 */
define([
    'app',
    './list/controller',
    './form/controller'
], function(App, ListController, FormController){

    var EmployeeApp = {};

    EmployeeApp.showList = function(options) {
        return new ListController(options);
    };

    EmployeeApp.showForm = function(id) {
        return new FormController({ id: id });
    };

    App.commands.setHandler('show:employee:list', function(options){
        return EmployeeApp.showList(options);
    });

    App.commands.setHandler('show:employee:form', function(id){
        return EmployeeApp.showForm(id);
    });

    return EmployeeApp;
});