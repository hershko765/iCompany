/**
 * Data Grid Formatters
 */
define(['moment'], function(){
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

    /**
     * Auto select value by given array
     * in the following format - { val : title }
     * @param arr
     * @param def
     * @returns {Function}
     * @constructor
     */
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

    /**
     * Format a date by given format
     * formats should be given as MomentJS library
     * see link below
     * @link http://momentjs.com/
     * @param format
     * @returns {Function}
     */
    Formatters.date = function(format) {
        return function(val) {
           return moment(val).format(format);
        }
    };

    return Formatters;
});