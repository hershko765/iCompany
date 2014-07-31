/**
 * ****DESCRIPTION OF FILE****
 *
 * @package    Sortex
 * @author     Sortex Systems Development Ltd.
 * @copyright  (c) 2011-2013 Sortex
 * @license    BSD
 * @link       http://www.sortex.co.il
 */
define(['backbone','app'], function(Backbone, App){

	var Collection = Backbone.Collection.extend({
        /**
         * Fetching collection and calling when:fetched event on success
         * @param options
         * @returns {Collection}
         */
		fetch: function(options){
			this._fetch({
				complete: function(collection, response){
                    App.execute('call:fetched', collection, response)
				},
				data: options
			});

            return this;
		},
        /**
         * Original Backbone Fetch
         * @returns {*}
         * @private
         */
        _fetch: function () {
            if (this.fetched) { return; }
            this.fetched = true;
            context.startTime = (new Date()).getTime();
            var map = this.map;

            //ask the plugin to load it now.
            if (this.shim) {
                context.makeRequire(this.map, {
                    enableBuildCallback: true
                })(this.shim.deps || [], bind(this, function () {
                        return map.prefix ? this.callPlugin() : this.load();
                    }));
            } else {
                //Regular dependency.
                return map.prefix ? this.callPlugin() : this.load();
            }
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