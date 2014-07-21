/*
* Main Configuration
*/
requirejs.config({
	paths: {
		jquery: 'vendor/jquery/dist/jquery',
		underscore: 'vendor/underscore/underscore',
        backbone: 'vendor/backbone/backbone',
        'backbone.babysitter': 'vendor/backbone.babysitter/lib/backbone.babysitter',
        'backbone.wreqr': 'vendor/backbone.wreqr/lib/backbone.wreqr',
        marionette: 'vendor/backbone.marionette/lib/core/amd/backbone.marionette',
		jqueryUI: 'vendor/jquery-ui-1.10.3.full.min',
		bootstrap: '../vendor/bootstrap.min',
		datagrid: 'vendor/datagrid/datagrid',
		toastr: 'vendor/toaster/toastr',
		select2: 'vendor/select2/select2',
		app: 'app',
        jqGrid: 'vendor/jquery.jqGrid/js/jqgrid.amd',
        text: 'vendor/text',
        aceExtra: '../vendor/ace-extra.min',
		aceAdmin: '../vendor/ace.min',
		aceEl: '../vendor/ace-elements.min',
		typHead: '../vendor/typeahead-bs2.min',
		fileUpload: '../vendor/fupload',
        serializeForm: 'vendor/serializeForm',
		selectView: 'config/views/selectView',
		duelSelect: 'vendor/duelselect/src/jquery.bootstrap-duallistbox',
        morris: 'vendor/morris.js/morris.min',
        raphael: 'vendor/morris.js/raphael',
        datePicker: 'vendor/bootstrap-daterangepicker-master/daterangepicker',
        moment: 'vendor/bootstrap-daterangepicker-master/moment.min'
	},
	shim: {
        moment: {
            deps: [ 'jquery', 'bootstrap' ]
        },
        datePicker: {
            deps: [ 'jquery', 'bootstrap', 'moment' ]
        },
        raphael: {
            deps: ['jquery']
        },
        morris: {
            deps: [ 'jquery', 'raphael' ]
        },
		duelSelect: {
			deps: [ 'jquery', 'bootstrap' ]
		},

		selectView: {
			deps: [ 'marionette' ]
		},
        aceAdmin: {
            deps: [ 'bootstrap', 'jquery', 'aceExtra' ],
            exports: 'ace'

        },
		select2: {
			deps: [ 'jquery' ]
		},
        serializeForm: {
            deps: [ 'jquery' ]
        },
        fileUpload: {
            deps: [ 'backbone' ]
        },
        typHead: {
            deps: [ 'bootstrap', 'jquery' ]
        },
        aceEl: {
            deps: [ 'aceAdmin' ]
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
		baseAdmin: {
			deps: [
				'jquery',
				'jqueryUI',
				'bootstrap'
			],
			exports: 'Application'
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
	'toastr',
	'selectView',
	'select2',
    'marionette',
    'morris',
    'jquery',
    'jqueryUI',
	'bootstrap',
	'typHead',
    'aceAdmin',
    'aceEl',
	'jqueryUI',
	'serializeForm',
	'datagrid',
	'entities/product',
	'entities/broker',
	'entities/split',
	'entities/rawlead',
	'entities/userSync',
	'entities/strategy',
	'entities/cache',
    'fileUpload',
    'datePicker',
    'splitter_app/dashboard/dashboard_app',
    'splitter_app/product/product_app',
    'splitter_app/splits/split_app',
    'splitter_app/broker/broker_app',
    'splitter_app/sidebar/sidebar_app',
    'splitter_app/main/main_app',
    'splitter_app/sentry/sentry_app',
    'splitter_app/sync/sync_app',
    'splitter_app/routes'
], function(App){
    setTimeout(function(){
        $('#boa-logo-container img').show({
            effect: 'slide',
            direction: 'left',
            duration: 1000
        });
    }, 500)
	// Change underscore template syntax to match twig
	_.templateSettings = { interpolate: /\{\{(.+?)\}\}/g, evaluate: /\<\@(.+?)\@\>/g };

    ace.settings.check('breadcrumbs', 'fixed');

    App.execute('show:sidebar');
    App.execute('show:main');

    // Start the app
	App.start();
});