/**
 * Data Grid Formatters
 */
define([], function(){
    var Formatters = {};

    /**
     * Icon ok / remove
     * to boolean values
     * @param val
     * @return string
     */
    Formatters.Boolean = function(val) {
        return '<span class="label label-' + (val ? 'success icon icon-ok' : 'danger icon icon-remove') +'"> '+ ' </span>';
    };

    /**
     * Create value link
     * @param val
     * @returns {string|outerHTML|*}
     */
    Formatters.Link = function(val){
        return $('<a></a>', { href: val }).html(val)[0].outerHTML
    };

    /**
     * Accept Default value to appear
     * instead of false values
     * @param def
     * @returns {Function}
     */
    Formatters.Default = function(def) {
        return function(val) {
            return val ? val: def
        }
    };

    Formatters.Translation = function(arr, def) {
        return function(val) {
            var chosenVal = def;
            $.each(arr, function(idx, value){
                if (idx == val) {
                    chosenVal = value;
                    return false;
                }
            });

            return chosenVal;
        }
    };

    return Formatters;
});