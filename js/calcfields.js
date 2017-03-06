(function($) {

    function get_decimal_from_total($total) {
        return parseInt($total.data('decimal'));
    }

    function round_dp(val, d) {
        var tens = Math.pow(10, d);
        if (d < 0){
            return val;
        }
        else {
            return Math.round(val * tens) / tens;
        }
    }

    function round_tbased($total, val) {
        return round_dp(val, get_decimal_from_total($total));
    }

    function setVal($total, val) {
        var curVal = round_tbased($total, parseFloat($total.text()));
        curVal += round_tbased($total, val);
        $total.text(round_tbased($total, curVal));
        $total.trigger('valuechange');
    }

    function field_checkbox($total, $field){
        var fchecked = $field.prop('checked'),
            fval = parseFloat($field.attr('value'));

        function change(e) {
            if ($field.prop('checked')){ setVal($total, fval); }
            else { setVal($total, -fval); }
        }

        if(fchecked) { setVal($total, fval); }
        $field.change(change);
    }

    function set_last_val($field, val) {
        var name = $field.attr('name'),
            fs = $('input[name=' + name + ']');
        fs.data('lastval', val);
    }

    function get_last_val($field) {
        return $field.data('lastval');
    }

    function field_radio($total, $field){
        var fchecked = $field.prop('checked'),
            fval = parseFloat($field.attr('value'));

        function change(e) {
            var lastval = get_last_val($field);
            fval = parseFloat($field.attr('value'));
            setVal($total, fval - lastval);
            set_last_val($field, fval);
        }

        if(fchecked) {
            setVal($total, fval);
            set_last_val($field, fval);
        }
        $field.change(change);
    }

    function proc_field($total, $field){
        var type = $field.attr('type');
        switch (type) {
            case 'radio':    field_radio($total, $field);    break;
            case 'checkbox': field_checkbox($total, $field); break;
        }
    }

    function find_id(item) {
        var classes = item.classList,
            classesl = classes.length,
            cls = '', i = 0, id = '';

        // Find total id in classes
        for( i = 0; i < classesl; ++i) {
            cls = classes[i];
            if(cls.startsWith('lscf_id_')) { return '.' + cls; }
        }
        return id;
    }

    /**
    * Proccess each total.
    */
    function proc_totals(index, item) {
        var $total = $(item),
            $fields = $('.lscf_field' + find_id(item)); // fields to control total
        $fields.each(function(index, item){ proc_field($total, $(item)); });
    }

    function proc_total_times(index, item) {
        var $tt = $(item),
            times = parseFloat($tt.data('times')),
            $total = $('.lscf_total' + find_id(item)).first();

        function settotal(ev) {
            $tt.text(
                round_tbased(
                    $total,
                    parseFloat($total.text()) * times));
        }
        settotal();
        $total.on('valuechange', settotal);
    }

    /**
    * Loop through all total shortcodes on page.
    */
    $(function() {
        $('.lscf_total_times').each(proc_total_times);
        $('.lscf_total').each(proc_totals);
    })

})(jQuery);
