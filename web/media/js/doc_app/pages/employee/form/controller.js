define([
    'app',
    'marionette',
    './view',
    'employee',
    'formController',
    'pwd'
], function(App, Marionette, View, EmployeeEntity, FormController, Pwd){
    var EmployeeListController;
    EmployeeListController = Marionette.Controller.extend({
        initialize: function(options) {
            var _this = this,
                layout = new View.Layout();

            layout.on('show', function(){
                _this.showForm(options.id, layout);
            });

            App.pageContentRegion.show(layout);
        },
        showForm: function(id, layout) {
            // Create form controller component to handle the form
            var formController = new FormController({
                id: id,
                updateModel: EmployeeEntity.getEmployee,
                createModel: EmployeeEntity.getEmptyEmployee,
                save: EmployeeEntity.saveEmployee,
                FormView: View.FormView,
                region: layout.formRegion
            });

            // Get formView element and set the password strength component
            var formView = formController.formView;
            this.listenTo(formView, 'render', function(){
                new Pwd({
                    $input: formView.$el.find('#password'),
                    region: formView.pwdRegion
                })
            });

            // Show form
            formController.showForm();
        }
    });

    return EmployeeListController;
});