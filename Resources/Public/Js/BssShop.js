/* global $ */
$.widget("bss.BssShop", {

    _create: function () {

        $('#tx-bss-shop').NavigationMobile();

        $('#tx-bss-shop').ProductThumbnails();

        $('#tx-bss-shop .list').Pagination();

        $('#tx-bss-shop').Orders();

        $('#tx-bss-shop .cart-wrapper').Cart();

        $('#tx-bss-shop .products').Products();

        $('.container > .row > .col-xl-7 > .row > div.product-build-info').Product();

        $('.container > .row > .col-xl-7 > .table-row').OrderStatus();

    }
});
