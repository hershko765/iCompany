define([
    'app',
    'marionette',
    './view',
    'datagrid'
], function(App, Marionette, View, DataGrid){
    var EmployeeListController;
    EmployeeListController = Marionette.Controller.extend({
        initialize: function(options) {
            var _this = this,
                layout = new View.Layout();

            layout.on('show', function(){
                _this.showGrid(options, layout);
            });

            App.pageContentRegion.show(layout);
        },
        showGrid: function(options, layout) {
            var Formatters = Marionette.InjectGrid.getFormatter(),
                InjectGrid = new Marionette.InjectGrid([layout.gridRegion, {
                fetchURL: '/api/v1/employees',
                filters: {
                    sort: 'first_name',
                    order: 'ASC',
                    perPage: 10
                },
                headers: [
                    [ 'first_name', 'Name', 10 ],
                    [ 'last_name', 'Last Name', 10 ],
                    [ 'email', 'Email', 25 ],
                    [ 'phone', 'Phone', 25 ],
                    [ 'created', 'Created', 25, Formatters.date('MMMM Do YYYY, h:mm:ss a') ]
                ],
                actions: [
                    { icon: 'pencil', type: 'default', execute: 'update:employee:clicked' },
                    { icon: 'times', type: 'danger', execute: 'delete:employee:clicked' }
                ]
            }]);

            this.listenTo(InjectGrid.injectLayout, 'update:employee:clicked', function(view){
                App.DocRoutes.navigate('#employees/form/' + view.model.get('id'), { trigger: true });
            });

        }
    });

    return EmployeeListController;
});