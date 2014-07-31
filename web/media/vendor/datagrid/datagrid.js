define([
	'app',
	'underscore',
	'backbone',
	'marionette',
	'../vendor/datagrid/datagridView',
	'../vendor/datagrid/tplVars',
	'../vendor/datagrid/mergeRecursive',
	'../vendor/datagrid/datagridEntity',
	'../vendor/datagrid/config',
    '../vendor/datagrid/Formatters'
], function(App, _, Backbone, Marionette, InjectView, tplVars, merge, Entity, config, Formatters){

	var Inject = Marionette.Controller.extend({
		initialize: function(options) {
			var _this = this, injectLayout, region;
            this.p = {};
			this.region = region = options[0];
			this.options = options[1];
			this.injectLayout = injectLayout = new InjectView.InjectLayout({});
			this.filters = $.extend((options[1].filters || {}), {
				order: this.options.order || 'id'
			});

            this.p.currentPage = this.filters.page ? this.filters.page[0] || 1 : 1;
            injectLayout.on('show', function() {
				_this.showGrid(injectLayout, _this.options);
			});

			region.show(injectLayout);
		},

		showGrid: function(layoutView, options) {
			var _this = this, injectTable;
			this.inejctTable = injectTable = new InjectView.ContainerView({
				templateHelpers: function() {
					return $.extend({
                        checkedColumn: options.checkedColumn
                    }, tplVars.containerVars(options))
				},
				itemViewVars: options
			});

			this.listenTo(injectTable, 'itemview:action:button:clicked', function(model, trigger){
				this.injectLayout.trigger(trigger, model);
			});

			injectTable.on('show', function(){
				var entity = Entity.createEntity({
					url: _this.options.fetchURL
				}), entityCollection;
				_this.collection = entityCollection = new entity.Collection();
				_this.renderRaws({
                    page: [ 1, _this.filters.perPage || config.fetch.perPage ]
				});

                _this.listenTo(injectTable, 'sort:table:clicked', function(col){
                    console.log(_this.filters.sort);
                    _this.renderRaws({
                        sort: col,
                        order: _this.filters.sort == col ? (_this.filters.order == 'DESC' ? 'ASC' : 'DESC') : 'DESC'
                    })
                });
			});

			layoutView.gridRegion.show(injectTable);
		},

		renderRaws: function(options) {
			options = options || {};
            if (options.page && ! $.isArray(options.page)) {
                options.page = [ options.page, this.filters.page[1] ];
            }
			var _this = this;
            options.get_total = true;
            options = $.extend((this.filters || {}), options);
            this.filters = options;
			_this.inejctTable.$el.find('.datagrid-loader').css('height', _this.inejctTable.$el.find('table').outerHeight() - 30 ).show();
            this.p.currentPage = options.page ? options.page[0] || 1 : 1;
			this.collection.fetchList((options || {}), function(c, r){
				_this.inejctTable.collection = _this.collection;
				_this.inejctTable.render();
				_this.inejctTable.$el.find('.datagrid-loader').hide();
				_this.renderPages(r.total);
			});
		},
		flushConfig: function(config) {
			this.options = merge(this.options, config);

			this.region.show(this.injectLayout);
		},
		toJSON: function(selectedOnly) {
			var $tbody = this.inejctTable.$el.find('tbody'), dataJSON = {}, rows = {};
            var $records = selectedOnly
            ? $tbody.find('tr.warning')
            : $tbody.find('tr');

            $records.each(function(idx, col){
				var $col = $(col);
				rows = {};
				dataJSON[$col.data('id')] = $col.find('td').each(function(i, v){
					if ( ! $(v).data('id')) return;
					rows[$(v).data('id')] = $(v).find('input').length ? $(v).find('input').val() : $(v).html();
				});

				dataJSON[$col.data('id')] = rows;
			});

			return dataJSON;
		},
        renderPages: function(total) {
            var perPage = this.filters.perPage || config.fetch.perPage,
                pageArr = [],
                _this = this;

            for(var i = 1; i <= Math.ceil(total / perPage); i++) {
                pageArr.push(i);
            }


            var pagingView = new InjectView.PagingView({
                templateHelpers: function() {
                    return {
                        limit: _this.filters.perPage || 10,
                        paging: pageArr,
                        hasTotal: !! total,
                        currentPage: _this.p.currentPage,
                        nextPage: _this.p.currentPage == pageArr.length ? null : _this.p.currentPage + 1,
                        prevPage: _this.p.currentPage == 1 ? null : _this.p.currentPage - 1,
                        checkedColumn: _this.options.checkedColumn,
                        checkedListeners: _this.options.checkedListeners
                    }
                }
            });

            this.listenTo(pagingView, 'paging:button:clicked', function(page){
                _this.renderRaws({
                    page: [ page, (_this.filters.perPage || config.fetch.perPage) ],
                    limit: (_this.filters.perPage || config.fetch.perPage),
                    offset: page * (_this.filters.perPage || config.fetch.perPage)
                })
            });

            this.listenTo(pagingView, 'datagrid:refresh:clicked', function(){
                _this.renderRaws({});
            });

            this.listenTo(pagingView, 'change:limit:clicked', function(limit){
                _this.filters.perPage = limit;
                _this.renderRaws({ page: [ 1, limit ]});
            });

            this.listenTo(pagingView, 'datagrid:checkedable:clicked', function(event){
                _this.injectLayout.trigger(event, _this.toJSON(true));
            });

            this.injectLayout.pagingRegion.show(pagingView);
        }
	});

	Marionette.InjectGrid = Inject;
    Marionette.InjectGrid.getFormatter = function() {
        return Formatters;
    }
});