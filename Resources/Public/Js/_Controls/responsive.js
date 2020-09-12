/* global $ */
$.widget("bss.responsive", {


    _create: function () {

        this.$container       = $('.container', this.element);
        this.$cart            = $('.cart', this.container);
        this.$accordion       = $('.accordion-toggle', this.container);
        this.$closeBtn        = $('.close-btn', this.cart);
        this.$destination     = $('#destination', this.container);
        this.$navbarCollapse  = $('#navbarCollapse', this.element);
        this.$closeMenu       = $('.close-menu', this.navbarCollapse);
        this.$cartBtn         = $('.cart-btn', this.element);

        this._smallerThanExtraLarge();

        this.$accordion.click(function () {

            this.$chevronUp    =  $('.fa-chevron-up', this);
            this.$chevronDown  =  $('.fa-chevron-down', this);

            this.$chevronUp.toggle();
            this.$chevronDown.toggle();

        });

        this.$closeMenu.click(() => {

            this.$navbarCollapse.removeClass("show");

        });
    },

    _smallerThanExtraLarge: function () {

        if ($(window).width() < 1200) {
            this.$cart.prependTo("#destination");
            this.$cart.removeClass("collapse");
            this.$cart.removeClass('cart');

            this.$container.addClass("container-fluid");
            this.$container.removeClass("container");

            this.$closeBtn.click(() => {
                this.$destination.css("display", "none");
            });

            this.$cartBtn.click(() => {
                this.$destination.toggle();
            });
        }

    },
});
