var ProductCollection = Backbone.Collection.extend({
    url: '/product',
    currentPage: 1,
    filterGroup:[],

    initialize: function (params) {
        this.limit = params.limit;
        this.on('reset update:param', this.getItems, this);
    },

    getItems: function () {
        var models = this.filterOut();
        var totalPages = Math.ceil(models.length/this.limit);

        models = this.rangeItems(models);

        this.trigger('update', models);
        this.trigger('update:count', totalPages);
    },

    setFilterGroup: function (filtersGroup) {
        this.currentPage = 1;
        this.filterGroup = filtersGroup;
        this.trigger('update:param')
    },

    setCurrentPage: function (page) {
        this.currentPage = page;
        this.trigger('update:param');
    },

    rangeItems: function (models) {
        var minRange = (this.currentPage * this.limit) - this.limit;
        var maxRange = (minRange + this.limit);

        return models.slice(minRange, maxRange);
    },

    filterOut: function () {
        var models = this.models;

        _.each(this.filterGroup, function (groups) {
            models = this.filterByConfiguration(models, groups)
        }, this);

        return models;
    },

    filterByConfiguration: function (models, groupFilter) {
        return _.filter(models, function (item) {
            var res = false;
            _.each(item.get('configurations'), function (v) {
                _.each(groupFilter, function (paramId) {
                    if (v['configId'] == paramId) {
                        res = true;
                    }

                    return res;
                });

                return res;
            });

            return res;
        });
    }
});