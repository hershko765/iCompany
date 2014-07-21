/**
 * ****DESCRIPTION OF FILE****
 *
 * @package    Sortex
 * @author     Sortex Systems Development Ltd.
 * @copyright  (c) 2011-2013 Sortex
 * @license    BSD
 * @link       http://www.sortex.co.il
 */
define(['.','app'], function(Backbone, App){

	var Collection = Backbone.Collection.extend({
		fetchList: function(options, callback){
			this.fetch({
				success: function(collection, response){

                    if (callback) { callback(collection) }
                    else { App.execute('call:fetched', collection, response) }
				},
				data: $.extend(options.filters, options.settings, options)
			});
            return this;
		}
	});


    App._pendingFetch = [];
    App.commands.setHandler('when:fetched', function(collection, callback){
        collection.fetchID = new Date().getTime();
        App._pendingFetch.push({
            callback: callback,
            collection: collection
        });
    });

    App.commands.setHandler('call:fetched', function(collection, response){

        $.each(App._pendingFetch, function(idx, val){
            if (val.collection.fetchID == collection.fetchID) {
                val.callback(collection, response);
            }
        });
    });

	return Collection
});