define(['marionette'], function(Marionette){
    var Validator = Marionette.Object.extend({
        initialize: function(options){
            this.p = {};
            this.p.fields = options;
        }
    });

    return Validator
});