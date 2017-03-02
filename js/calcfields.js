(function($) {

    function setVal($total, val) {
        var curVal = parseFloat($total.text());
        curVal += val;
        $total.text(curVal);
    }

    function field_box($total, $field){
        var fchecked = $field.prop('checked'),
            fval = parseFloat($field.attr('value'));

        function change(e) {
            if ($field.prop('checked')){
                setVal($total, fval);
            }
            else {
                setVal($total, -fval);
            }
        }

        if(fchecked) { setVal($total, fval); }
        $field.change(change);
    }

    function proc_field($total, $field){
        var type = $field.attr('type');
        switch (type) {
            case 'radio':
            case 'checkbox':
                field_box($total, $field)
                break;
        }
    }

    /**
    * Proccess each total.
    */
    function proc_totals(index, item) {
        var classes = item.classList,
            classesl = classes.length,
            $total = $(item),
            cls = null,     // classes on total
            id = null,      // id of fields to be using
            $fields = null; // fields to control total

        // Find total id in classes
        for( i = 0; i < classesl; ++i) {
            cls = classes[i];
            if(cls.startsWith('lscf_id_')) {
                id = cls;
            }
        }

        // If ID exists use fields with the ID.
        // Else use any field found on the page.
        if(id) {
            $fields = $('.lscf_field.' + id);
        }
        else {
            $fields = $('.lscf_field');
        }

        $fields.each(function(index, item){ proc_field($total, $(item)); });
    }

    /**
    * Loop through all total shortcodes on page.
    */
    $(function() {
        $('.lscf_total').each(proc_totals);
    })

})(jQuery);
