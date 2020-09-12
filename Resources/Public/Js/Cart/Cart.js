/* global $ */
$.widget("bss.Cart", {

    _create: function () {

        this.$container   = this.element;
        this.showAction   = this.$container.data('show');
        this.editAction   = this.$container.data('edit');
        this.deleteAction = this.$container.data('delete');

        this.showCart();
    },

    _init: function () {

        this.$cart  = this.$container.find('.cart');
        this.$trash = this.$container.find('.trash');

        this.$container.find('.input-plus-minus').inputPlusMinus({change: this.change.bind(this)});

        this.$trash.on('click', (event) => {
            this.delete($(event.target).data('buildid'));
        })
    },

    change: function(el, val) {

        this.editCart(el.closest('.cartitem').data('buildid'), val);

    },

    addToCart: function(buildUid) {

        var $item =  $('.cartitem[data-buildid=' + buildUid + '] .input-plus-minus');

        var amount =  ($item.length != 0)
            ? $item.inputPlusMinus('value')
            : 0;

        amount += 1;

        this.editCart(buildUid, amount);

    },

    showCart: function() {

        var thiz = this;

        $.ajax({
            url: this.showAction,
            dataType: 'html',
            type: "post",
            data: {
                nochache: true
            },
            success: function (result) {

                thiz.$container.html(result);

                thiz._init();

            },
            error: function () {
                console.log('Error, Ajax not working');
            }
        });
    },

    editCart: function(buildUid, amount) {

        var thiz = this;

        $.ajax({
            url: this.editAction,
            dataType: 'html',
            type: "post",
            data: {
                buildid: buildUid,
                amount:  amount
            },
            success: function (result) {

                thiz.$container.html(result);

                thiz._init();

            },
            error: function () {
                console.log('Error, Ajax not working');
            }
        });
    },

    delete: function (buildUid) {

        var thiz = this;

        $.ajax({
            url: this.deleteAction,
            dataType: 'html',
            type: "post",
            data: {
                buildid: buildUid
            },
            context: {
                container: this.$container
            },
            success: function (result) {

                this.container.html(result);

                thiz._init();

            },
            error: function () {
                console.log('Error, Ajax not working');
            }
        });
    },

});

