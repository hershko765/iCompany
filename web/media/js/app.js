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
    App.addRegions({ });

    // Image Preloader
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

    return App;
});
