/**
 * Employee Entity
 */
define([
	'app',
	'collection',
	'model'
], function(App, Collection, Model){
    return false;

	var Employee = {};

	Employee.Model = Model.extend({
		urlRoot: '/api/v1/employees'
	});

	Employee.Collection = Collection.extend({
		url: '/api/v1/employees'
	});

	var API = {
        saveEmployee: function(data, id) {
            var entity = new Employee.Model({ id: id });
	        entity.save(data);
        },
		getEmployee: function(id) {
			var entity = new Employee.Model({ id: id });
			entity.fetchCall(callback);
		},

		getEmployees: function(options) {
            options = options || {};
			var entities = new Employee.Collection();
			return entities.fetch(options);
		}
	};


    App.reqres.setHandler('get:empty:entity', function(id, callback){
        return new Employee.Model;
    });

    App.commands.setHandler('get:employee:entity', function(id, callback){
        API.getEmployee(id, callback);
    });

    App.reqres.setHandler('get:employee:entities', function(options, callback){
        return API.getEmployees(options, callback);
    });

    App.reqres.setHandler('save:employee:entity', function(data, id, callback){
        return API.saveEmployee(data, id, callback);
    });


	return API;
});