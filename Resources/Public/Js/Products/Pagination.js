/* global $ */
$.widget("bss.Pagination", {


    _create: function () {

        this.$container   = $('.products');
        this.$products    = $('#tx-bss-shop .products');
        this.search       = $('input[name="tx_bssshop_bssshop[search]"]').val();
        this.sort         = $('.order').find(":selected").val();
        this.$loader      = $('.loader');
        this.url          = this.$container.attr('data-pagination');
        this.category     = this.$container.attr('data-category');
        this.limit        = this.$container.attr('data-limit');

        this.$loader.hide();

        $(window).on('scroll', () => {

            var position = $(window).scrollTop();
            var bottom = $(document).height() - $(window).height();

            if (position === bottom) {

                this.$offset = this.$products.find("input:last").val();

                if (this.$offset !== 'false') {

                    var thiz = this;
                    var container = this.$container;
                    var limit = this.limit;

                    $.ajax({
                        type: 'POST',
                        url: thiz.url,
                        data: {
                            offset: Number(thiz.$offset) + parseInt(limit),
                            search: thiz.search,
                            sort: thiz.sort,
                            category: thiz.category,
                            limit: thiz.limit
                        },
                        beforeSend: function(){
                            thiz.$loader.show();
                        },
                        success: function (result) {

                            container.append(result);
                            thiz.$loader.hide();

                            thiz.$products.Products('destroy');
                            thiz.$products.Products('addToCart');

                        }
                    });
                }
            }
        });
    }
});






