/* globals $ */

$.widget("bss.OrderStatus", {

    _create: function () {

        this.$select      = $('select', this.element);
        this.ajaxUrl      = this.$select.attr('data-action');
        this.orderUid     = this.$select.attr('data-order');
        this.container    = this.element;

    },

    _init: function () {

        this._change();

    },

    _change: function () {

        this.$select      = $('select', this.element);
        this.$select.on('change', () => {

            this.load();

        });

    },

    load: function () {

        this.statusUid = this.$select.find(':selected').val();
        var thiz = this;
        var container = this.container;

        $.ajax({
            url: thiz.ajaxUrl,
            dataType: 'html',
            cache: false,
            type: "post",
            data: {
                orderUid: thiz.orderUid,
                statusUid: thiz.statusUid
            },
            success: function (result) {

                container.html(result);

                thiz._change();

            },
            error: function () {
                console.log('Error, Ajax not working');
            }
        });
    },

});
