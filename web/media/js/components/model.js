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

	var Model = Backbone.Model.extend({
		destroyCall: function(after){
			return this.destroy({
				success: function(model, response){
					if( after ) { after() }
				}
			});
		},

		saveCall: function(data, options){
			this.save(data, options)
		},

		fetchCall: function(callBack, options){
			this.fetch({
				success: function(model, response){
					// Call after function
					if(callBack) { callBack(model, response) }
				},
				data: options
			})
		}
	});

	return Model
});