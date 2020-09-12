/* globals $ */

$.widget("bss.Product", {

    _create: function () {

        this.$select      = $('select', this.element);
        this.$addToCart   = $('.add-to-cart');
        this.ajaxUrl      = this.$select.attr('data-build');
        this.container    = this.element;

    },

    _init: function () {

        this._change();

    },

    _change: function () {

        this.$select.on('change', () => {

            this.load();

        });

        this.$addToCart.on('click', () => {

            this.$addToCart.attr('disabled', 'disabled');

            setTimeout( () => {
                this.$addToCart.removeAttr('disabled');
            }, 2000);

            $('#tx-bss-shop .cart-wrapper').Cart('addToCart', this.$addToCart.data('buildid'));
        })
    },

    load: function () {

        this.buildUid = this.$select.val();
        var thiz = this;
        var container = this.container;

        $.ajax({
            url: thiz.ajaxUrl,
            dataType: 'html',
            cache: false,
            type: "post",
            data: {
                buildid: this.buildUid,
            },
            success: function (result) {

                container.html(result);

                thiz.$select = $('select', thiz.element);

                $('#tx-bss-shop').ProductThumbnails('changeImageOnSelect', thiz.buildUid);

                thiz.$addToCart = $('.add-to-cart');

                thiz._change();

            },
            error: function () {
                console.log('Error, Ajax not working');
            }
        });
    },

});
