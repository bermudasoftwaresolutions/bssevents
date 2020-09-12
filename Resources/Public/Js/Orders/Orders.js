/* globals $ */

$.widget("bss.Orders", {

    _create: function () {

        this.$order = $('.order');

        this.$order.on('change', () => {

            window.location.href = this.$order.find(':selected').data('order');

        });

    },

});
