/**
 * Top Navbar Application
 */
define(['app', './controller'], function(App, TopNavController){

    var TopNavbar = {};

    TopNavbar.ShowNavbar = function(options) {
        return new TopNavController(options);
    };

    App.commands.setHandler('show:top:navbar', function(options){
        return TopNavbar.ShowNavbar(options);
    });

    return TopNavbar;
});