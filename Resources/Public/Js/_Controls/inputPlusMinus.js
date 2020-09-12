/* global $ */
$.widget("bss.inputPlusMinus", {
    
    options: {
        change: null
    },


    _create: function () {

        this.$input     = $("input.input-number", this.element);
        this.$plus      = $(".input-group-btn .plus",  this.element);
        this.$minus     = $(".input-group-btn .minus", this.element);

        this.min        = parseInt(this.$input.attr('min'));
        this.max        = parseInt(this.$input.attr('max'));

        this.allowedKeys();
        this.minMaxValue();
        
        var thiz = this;

        this.$input
            .focusin(function () { thiz.storeLastValue() })
            .change (function () {
                thiz.minMaxValue();
                thiz.value(thiz.value())

            });

        this.$plus.click(function (e) {
            e.preventDefault();

            var clickedEl = $(e.currentTarget);

            thiz.value(thiz.value() + 1, clickedEl);
        });

        this.$minus.click(function (e) {
            e.preventDefault();

            var clickedEl = $(e.currentTarget);

            thiz.value(thiz.value() - 1, clickedEl);
        });

    },

    value: function (val, clickedEl) {
        var v = isNaN(val)
            ? parseInt(this.$input.val()) 
            : val;
        
        if (isNaN(v)) {
            v = 0;
        }
        
        if (!isNaN(val)) {
            this.storeLastValue();
            this.$input.val(v);

            // callback
            if (this.options.change) {
                if (clickedEl) {
                    clickedEl.attr('disabled', 'disabled');
                }
                setTimeout( () => {

                    this.options.change(this.element, val);
                }, 300);

            }
        }
        return v;
    },

    minMaxValue: function () {
        if (this.$input.val() >= this.max) {
            this.$plus.attr('disabled', 'disabled');
            this.resetToLastValue();
        } else {
            this.$plus.removeAttr('disabled');
        }
            
        if (this.$input.val() <= this.min) {
            this.$minus.attr('disabled', 'disabled');
            this.resetToLastValue();
        } else {
            this.$minus.removeAttr('disabled');
        }
        
    },

    storeLastValue: function () {
            this.$input.data('lastValue', this.value());
    },

    resetToLastValue: function () {
        if (parseInt(this.$input.val()) !== this.min) {
            this.value(this.$input.data('lastValue'));
        }
    },

    allowedKeys: function () {

        this.$input.keydown(function (e) {
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                // Allow: Ctrl+A
                (e.keyCode == 65 && e.ctrlKey === true) ||
                // Allow: home, end, left, right
                (e.keyCode >= 35 && e.keyCode <= 39)) {
                // let it happen, don't do anything
                return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });

    }
});