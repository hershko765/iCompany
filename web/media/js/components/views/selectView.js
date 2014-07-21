/**
 * ****DESCRIPTION OF FILE****
 *
 * @package    Sortex
 * @author     Sortex Systems Development Ltd.
 * @copyright  (c) 2011-2013 Sortex
 * @license    BSD
 * @link       http://www.sortex.co.il
 */
define([
	'app',
	'marionette'
], function(App, Marionette){
	var SelectView = {};

	SelectView.OptionView = Marionette.ItemView.extend({
		tagName: 'option',
		template: _.template('<%= title %>'),
		attributes: function(){
			var view = this;
            var IDField = 'id';
            if (view.options.IDField instanceof Array) {
                var field = '';
                $.each(view.options.IDField, function(k, val){
                    field += view.model.get(val) + '|';
                });
                IDField = field.slice(0, -1);
            }
            else if (view.options.IDField) {
                IDField = this.model.get(view.options.IDField)
            }

			var attr = {
				value : IDField || null
			};

            if(this.options.selected) {
                if((this.options.selected) == this.model.get(
                    ( view.options.selectedCol ? view.options.selectedCol : view.options.IDField || 'id' )
                )){
                    attr.selected = 'selected'
                }
            }

			return attr;
		},
		templateHelpers: function() {
			if ( ! this.options.title ) return {};

			return {
				title: $.isFunction(this.options.title) ? this.options.title(this, this.model) : this.model.get(this.options.title) || this.model.get('title')
			};
		}
	});

	SelectView.Wrapper = Marionette.CollectionView.extend({
		tagName: 'optgroup',
		attributes: {
			label: 'Select'
		},
		itemView: SelectView.OptionView
	});

	App.reqres.setHandler('select:view', function(collection, options){
        if (options.emptyLabel) {
            var emptyLabel = {};
            emptyLabel[options.title] = '- All -';
            emptyLabel[(options.IDField || 'id')] = "null";
            collection.unshift(emptyLabel);
        }

		return new SelectView.Wrapper({
			collection: collection,
			itemViewOptions: options || {}
		});
	});
});