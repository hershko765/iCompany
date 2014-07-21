/**
 * Broker Entity
 */
define([
	'app',
	'config/collection',
	'config/model'
], function(App, Collection, Model){

	var Broker = {};

	Broker.Model = Model.extend({
		urlRoot: '/api/v1/brokers'
	});

	Broker.Collection = Collection.extend({
		url: '/api/v1/brokers/'
	});

	var API = {
        saveBroker: function(data, id, callback) {
            var entity = new Broker.Model({ id: id });
	        entity.save(data);

        },
		getBroker: function(id, callback) {
			var entity = new Broker.Model({ id: id});
			entity.fetchCall(callback);
		},

		getBrokers: function(options, callback) {
			var entities = new Broker.Collection();
			return entities.fetchList((options || {}), callback);
		}
	};


      App.reqres.setHandler('get:empty:entity', function(id, callback){
        return new Broker.Model;
    });

    App.commands.setHandler('get:broker:entity', function(id, callback){
        API.getBroker(id, callback);
    });

    App.reqres.setHandler('get:broker:entities', function(options, callback){
        return API.getBrokers(options, callback);
    });

    App.commands.setHandler('save:broker:entity', function(data, id, callback){
        API.saveBroker(data, id, callback);
    });


	return API;
});