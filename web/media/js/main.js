/*
* Main Configuration
*/
requirejs.config({
	paths: {
        app: 'app',
        jquery: '../vendor/jquery/dist/jquery',
        underscore: '../vendor/underscore/underscore',
        backbone: '../vendor/backbone/backbone',
        'backbone.babysitter': '../vendor/backbone.babysitter/lib/backbone.babysitter',
        'backbone.wreqr': '../vendor/backbone.wreqr/lib/backbone.wreqr',
        marionette: '../vendor/backbone.marionette/lib/core/amd/backbone.marionette',
        jqueryUI: '../vendor/jquery-ui-1.11.0/jquery-ui',
        bootstrap: '../vendor/bootstrap-3.2.0-dist/js/bootstrap',
        datagrid: '../vendor/datagrid/datagrid',
        toastr: '../vendor/toaster/toastr',
        select2: '../vendor/select2/select2',
        text: '../vendor/requirejs/text',
		selectView: 'components/views/selectView',
        collection: 'components/collection',
		model: 'components/model'
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
	'selectView',
	'select2',
    'marionette',
    'jquery',
    'jqueryUI',
	'bootstrap',
	'datagrid',
	'entities/employee',
    'icompany_app/app_routes',
    'icompany_app/dashboard_app/dashboard_app'
], function(App){
	// Change underscore template syntax to match twig
	_.templateSettings = { interpolate: /\{\{(.+?)\}\}/g, evaluate: /\<\@(.+?)\@\>/g };

    // Start the app
	App.start();
});