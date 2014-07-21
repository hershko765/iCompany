/**
 * Initialize App
 */
define([
    'marionette',
    'underscore',
	'components/dialog',
	'components/confirm'
], function(Marionette, _){

    // Initialize App
    var App = new Marionette.Application();

    // Add top level regions
    App.addRegions({ });

    App.imageLoader = function($el) {
        $el.find('.pre-load').each(function(key, el){
            var $el = $(el),
                src = $(el).css('background-image').replace('url(', '').replace(')', '');
            $('<img/>').attr('src', src).load(function() {
                setTimeout(function(){
                    $el.animate({opacity: 1});
                }, (Math.random() * 200));
                $(this).remove(); // prevent memory leaks
            });
        });
    };

    return App;
});
