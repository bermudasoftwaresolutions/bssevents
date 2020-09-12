/* global $ */
$.widget("bss.ProductThumbnails", {

    _create: function () {

        this.$slider         = $('.gallery-slider', this.element);
        this.$carousel       = $('.gallery-carousel', this.element);
        this.$carouselItems  = $('.carousel-item', this.element);
        this.buildUid        = $('.select-build').find(':selected').val();

        this._slider();

        this._carousel();

        setTimeout( () => {
            this.changeImageOnSelect(this.buildUid);
        }, 200);

    },

    _slider: function () {

        this.$slider.flexslider({
            directionNav: false,
            controlNav: false,
            selector: ".slider-container > .gallery-item",
            animation: "fade",
            animationSpeed: 100,
            animationLoop: false,
            slideshow: false,
            sync: ".single-carousel"
        });

    },

    _carousel: function () {

        this.$carousel.flexslider({
            animation: "slide",
            start: slider => {
                this.$carousel.resize();
            },
            controlNav: false,
            directionNav: true,
            animationLoop: false,
            slideshow: false,
            itemWidth: 72,
            itemMargin: 9,
            asNavFor:  this.$slider,
            maxItems: 4,
            minItems: 2,
            prevText: "<i class=\"fa fa-chevron-left\"></i>",
            nextText: "<i class=\"fa fa-chevron-right\"></i>",
            selector: ".carousel-content > .carousel-item"
        });

    },

    changeImageOnSelect: function (uid) {

        this.$carouselItems.each(function () {
            var data = $(this).data('build');
            if (uid == data) {
                $(this).trigger("click")
                return false;
            }
        });

    },
});

