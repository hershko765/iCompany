define(['app', 'marionette'], function(App, Marionette){
    var FormController;
    FormController = Marionette.Controller.extend({
        initialize: function(options) {
            this.options = options;
            var entity = options.id
            ? options.updateModel(options.id)
            : options.createModel();

            // Check if form is update or create
            var formView = this.formView = new options.FormView({
                model: entity,
                templateHelpers: function() {
                    return {
                        ifNew: function(createTitle, UpdateTitle) {
                            return options.id ? UpdateTitle : createTitle
                        },
                        isNew: ! options.id
                    }
                }
            });

            entity.on('sync', function(){
                formView.render();
            });
        },
        showForm: function() {
            this.options.region.show(this.formView);
        }
    });

    return FormController;
});