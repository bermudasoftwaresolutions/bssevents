/* global $ */
$.widget("bss.Products", {

    options:{
        timer: 2000
    },


    _create: function () {

        this.$order = $('.order');

        this.$order.on('change', () => {

            window.location.href = this.$order.find(':selected').data('order');

        });

        this.addToCart()
    },

    addToCart: function () {


        this.$addToCart = $('.add-to-cart');

        this.$addToCart.on('click', (event) => {

            var clickedEl = $(event.currentTarget);

            $('#tx-bss-shop .cart-wrapper').Cart('addToCart', clickedEl.closest('.product').data('builduid'));

        });

    },

    destroy: function ()
    {
        console.log(this.$addToCart);
        this.$addToCart.unbind();
    }

});



















