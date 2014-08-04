/*
* Main Configuration
*/
requirejs.config({
	paths: {
        app: 'app',
        moment: '../../vendor/moment/moment',
        jquery: '../../vendor/jquery/dist/jquery',
        underscore: '../../vendor/underscore/underscore',
        backbone: '../../vendor/backbone/backbone',
        'backbone.babysitter': '../../vendor/backbone.babysitter/lib/backbone.babysitter',
        'backbone.wreqr': '../../vendor/backbone.wreqr/lib/backbone.wreqr',
        marionette: '../../vendor/backbone.marionette/lib/backbone.marionette',
        jqueryUI: '../../vendor/jquery-ui-1.11.0/jquery-ui',
        bootstrap: '../../vendor/bootstrap-3.2.0-dist/js/bootstrap',
        datagrid: '../../vendor/datagrid/datagrid',
        toastr: '../../vendor/toaster/toastr',
        select2: '../../vendor/select2/select2',
        text: '../../vendor/requirejs/text',
        // Components
		selectView: '../components/views/selectView',
        collection: '../components/collection',
		model: '../components/model',
        formController: '../components/controller/form',
        pwd: '../components/pwd/pwd',
        // Entities
        employee: '../entities/employee'
	},
	shim: {
        moment: {
            deps: [ 'jquery', 'bootstrap' ]
        },
        datePicker: {
            deps: [ 'jquery', 'bootstrap', 'moment' ]
        },
		selectView: {
			deps: [ 'marionette' ]
		},
		select2: {
			deps: [ 'jquery' ]
		},
		underscore: {
			exports: '_'
		},
		backbone: {
			deps: [
				'underscore',
				'jquery'
			],
			exports: 'Backbone'
		},
		datagrid: {
			deps: [ 'marionette' ]
		},
		jqueryUI: {
			deps: [ 'jquery' ]
		},
		bootstrap: {
			deps: [
				'jquery'
			]
		},
		marionette: {
			deps: [
				'backbone',
				'backbone.babysitter',
				'backbone.wreqr'
			],
			exports: 'Marionette'
		}
	}
});

require([
	'app',
    'top_regions/initialize',
	'selectView',
	'select2',
    'marionette',
    'jquery',
    'jqueryUI',
	'bootstrap',
	'datagrid',
	'employee',
    'routes'
], function(App, TopRegions){
    window.App = App;
	// Change underscore template syntax to match twig
	_.templateSettings = { interpolate: /\{\{(.+?)\}\}/g, evaluate: /\<\@(.+?)\@\>/g };

    // Show Application Theme
    TopRegions.initialize();

    // Start the app
	App.start();
});