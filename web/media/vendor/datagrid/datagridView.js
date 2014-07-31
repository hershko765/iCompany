define([
    'app',
	'underscore',
	'backbone',
	'marionette',
	'text!/media/vendor/datagrid/templates/layout.twig',
	'text!/media/vendor/datagrid/templates/_table.twig',
	'text!/media/vendor/datagrid/templates/_raw.twig',
	'text!/media/vendor/datagrid/templates/_paging.twig'
], function(App, _, Backbone, Marionette, TplLayout, TplTable, TplRaw, TplPaging){
	var InjectView = {};
	InjectView.InjectLayout = Marionette.Layout.extend({
		template: TplLayout,
		regions: {
			gridRegion: '#grid-region',
			pagingRegion: '#paging-region'
		}
	});

	InjectView.RawView = Marionette.Layout.extend({
		template: TplRaw,
		tagName: 'tr',
		onRender: function() {
			this.$el.attr('data-id', this.model.get('id'));
		},
		templateHelpers: function(){
			var model = this.model, _this = this, rawData = [];
			$.each(this.options.config.headers, function(idx, val){
				rawData.push({
					name: val[0],
					title: val[3] ? val[3](model.get(val[0]), model) : model.get(val[0]),
                    width: val[2] ? val[2] : 100
				})
			});

            var actions = _this.options.config.actions || [], readyActions = [];
            $.each(actions, function(idx, val){
                readyActions[idx] = $.isFunction(val) ? val(_this, model) : val;
            });

			return {
                checkedColumn: this.options.config.checkedColumn,
				rawData: rawData,
                actions: readyActions
            };
		},
        events: {
            'click .actionButton': function(e) {
	            this.trigger('action:button:clicked', $(e.currentTarget).data('trigger'), this);

                e.preventDefault();
            },
            'change .datagrid-checkbox': function(e) {
                $(e.currentTarget).parents('tr:first').toggleClass('warning');
            }
        }
	});

    InjectView.PagingView = Marionette.ItemView.extend({
        template: TplPaging,
        events: {
            'click a': function(e) {
                var page = $(e.currentTarget).data('page');
                if ( ! page ) return false;
                
                this.trigger('paging:button:clicked', parseInt(page));
                e.preventDefault();
            },
            'click .datagrid-render-click': function(){
                this.trigger('datagrid:refresh:clicked')
            },
            'change  #per-page': function(e) {
                this.trigger('change:limit:clicked', $(e.currentTarget).val() )
            },
            'click #datagrid-checkable-btn': function() {
                var action = $('#datagrid-checkable-action').val();
                var event = $('#checkable_' + action).data('trigger');
                this.trigger('datagrid:checkedable:clicked', event)
            }
        }
    });

	InjectView.ContainerView = Marionette.CompositeView.extend({
		template: TplTable,
		itemViewContainer: 'tbody',
		itemView: InjectView.RawView,
        events: {
            'click .sort-header': function(e) {
                var $target = $(e.currentTarget);
                this.trigger('sort:table:clicked', $target.data('sort'));
            },
            'click .datagrid-checkable-checkall': function(e) {
                var toCheck = $(e.currentTarget).is(':checked'),
                    $checkboxes = this.$el.find('.datagrid-checkbox');
                $checkboxes.prop('checked', toCheck);

                toCheck
                ? $checkboxes.parents('tr').not('.datagrid-thead').addClass('warning')
                : $checkboxes.parents('tr').not('.datagrid-thead').removeClass('warning')
            }
        },
		itemViewOptions: function() {
			return { config: this.options.itemViewVars }
		}
	});

	return InjectView;
});