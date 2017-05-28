var PaginationView = Backbone.View.extend({
    el: '#navigation',
    template:_.template($('#pagination-item').html()),
    events: {
        'click a': 'onClick'
    },
    totalPages: 0,
    currentPage: 1,
    limit:5,

    render:function () {
        this.clear();
        var itemClass = '';

        for(var i = 1; i <= this.totalPages; i++){
            if (this.currentPage == i) {
                itemClass = 'active';
            }else{
                itemClass = 'numb-page';
            }

            this.addOne(i, itemClass);
        }
    },

    clear:function () {
        this.$el.html('');
    },

    addOne:function(num,itemClass){
        this.$el.append(this.template({
            num: num,
            itemClass:itemClass
        }));
    },

    setTotalPages:function (count){
        this.totalPages = count;
        this.render();
    },

    onClick: function (e) {
        e.preventDefault();
        this.currentPage = $(e.currentTarget).data('page');
        this.trigger('nav:click', this.currentPage);
    }
});