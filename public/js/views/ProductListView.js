$(function () {
    var AppProductView = Backbone.View.extend({
        el: '#product-page',

        initialize: function () {
            this.filter = new ProductFiltersView();
            this.product = new ProductItemsView();
            this.navigation = new PaginationView();
            this.filterCollection = new FilterCollection();
            this.productCollection = new ProductCollection({
                limit: 40
            });

            this.productCollection.fetch({reset: true});
            this.filterCollection.fetch({reset: true});

            this.filterCollection.on('reset', this.filter.render, this.filter);
            this.navigation.on('nav:click', this.productCollection.setCurrentPage, this.productCollection);
            this.productCollection.on('update:count', this.navigation.setTotalPages, this.navigation);
            this.filter.on('chosen', this.productCollection.setFilterGroup, this.productCollection);
            this.productCollection.on('update', this.product.render, this.product);
        }

    });

    var ProductItemsView = Backbone.View.extend({
        el: '#product-list',
        template: _.template($('#product-item').html()),

        render: function (itemList) {
            this.clear();
            _.each(itemList, this.addItem, this);
        },

        addItem: function (item) {
            this.$el.append(this.template({
                item: item.toJSON()
            }))
        },

        clear: function () {
            this.$el.html('');
        }
    });


    new AppProductView();

});