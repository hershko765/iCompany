/**
 * Initialize App
 */
define([
    'marionette',
    'underscore'
], function(Marionette, _){

    // Initialize App
    var App = new Marionette.Application();

    // Add top level regions
    App.addRegions({
        topBarRegion: '#top-bar',
        subNavbarRegion: '#sub-navbar',
        pageContentRegion: '#page-content-region'
    });

    // Image Pre loader
    App.imageLoader = function($el) {
        $el.find('.pre-load').each(function(key, el){
            var $el = $(el),
                src = $(el).css('background-image').replace('url(', '').replace(')', '');
            $('<img/>').attr('src', src).load(function() {
                $el.animate({opacity: 1});
                $(this).remove(); // prevent memory leaks
            });
        });
    };

    // Create initialize after method
    App.on('start', function () {
        App.getCurrentRoute = function(){
            return Backbone.history.fragment
        };

        if (Backbone.history) {
            Backbone.history.start();
        }
    });
    return App;
});
