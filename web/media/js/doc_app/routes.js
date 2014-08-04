define([
    'app',
    'backbone'
], function(App, Backbone){
    // define route
    var Routes = Backbone.Marionette.AppRouter.extend({
        // map path to function
        routes : {
            '' : 'showDashboard',
            'employees': 'employeeList',
            'employees/form(/:id)': 'employeeForm'
        },
        showDashboard: function() {
            require(['pages/dashboard/dashboard_app'], function(DashboardApp){
                DashboardApp.showDashboard();
            })
        },
        employeeList: function() {
            require(['pages/employee/employee_app'], function(EmployeeApp){
                EmployeeApp.showList();
            })
        },
        employeeForm: function(id) {
            require(['pages/employee/employee_app'], function(EmployeeApp){
                EmployeeApp.showForm(id);
            })
        }
    });

    /**
     * Creating Route and settings on route event
     */
    App.addInitializer(function () {
        App.DocRoutes = new Routes({});
        App.DocRoutes.on('route', function(route, params){
        });
    });

    return Routes;
});