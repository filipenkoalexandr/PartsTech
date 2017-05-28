var ProductFiltersView = Backbone.View.extend({
    el: '#product-filters',
    template: _.template($("#filter-group").html()),
    events: {
        'change input[type="checkbox"]': 'onChosen'
    },

    render: function (collection) {
        var grouping = collection.groupBy('name');

        _.each(grouping, this.addOne, this);
    },

    addOne: function (item, title) {
        this.$el.append(this.template({
            title: title,
            filter: item
        }));
    },

    onChosen: function (e) {
        var group = {};

        this.$el.find('input[type=checkbox]:checked').each(function (n, el) {
            var url = $(el).data('url');
            if (url in group) {
                group[url][n] = $(el).val();
            } else {
                group[url] = {};
                group[url][n] = $(el).val();
            }
        });

        this.trigger('chosen', group);
    }
});