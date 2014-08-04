/**
 * Top Navbar Application
 */
define(['app', './controller'], function(App, DashboardController){

    var DashboardApp = {};

    DashboardApp.showDashboard = function(options) {
        return new DashboardController(options);
    };

    App.commands.setHandler('show:dashboard', function(options){
        return DashboardApp.showDashboard(options);
    });

    return DashboardApp;
});