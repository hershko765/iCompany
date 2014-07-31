define(['app', './controller', 'backbone'], function(App, DashboardController, Backbone){

    var MyRouter = Backbone.Marionette.AppRouter.extend({
        // "someMethod" must exist at controller.someMethod
        appRoutes: {
            "some/route": "someMethod"
        },

        /* standard routes can be mixed with appRoutes/Controllers above */
        routes : {
            "some/otherRoute" : "someOtherMethod"
        },
        someOtherMethod : function(){
            console.log('123');
            // do something here.
        }

    });
});