/**
 * Initialize Top Regions
 */
define([
    'app',
    'top_regions/topbar/topbar_app',
    'top_regions/subnavbar/subnavbar_app'
], function(App, TopNavBar, SubNavbar){

    // Initialize Template
    var TopRegions = {};
    TopRegions.initialize = function() {
        // Show top navigation bar
        TopNavBar.ShowNavbar();

        // Show top menu navigation
        SubNavbar.ShowSubNavbar();
    };

    return TopRegions;
});