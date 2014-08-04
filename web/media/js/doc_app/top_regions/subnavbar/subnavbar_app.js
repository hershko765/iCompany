/**
 * Top Subnavbar Application
 */
define(['app', './controller'], function(App, SubNavbarController){

    var Subnavbar = {};

    Subnavbar.ShowSubNavbar = function(options) {
        return new SubNavbarController(options);
    };

    App.commands.setHandler('show:sub:navbar', function(options){
        return Subnavbar.ShowSubNavbar(options);
    });

    return Subnavbar;
});