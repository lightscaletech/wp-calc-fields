(function($) {
    function proc_totals(index, item) {
        var classes = item.classList,
            classesl = classes.length,

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
            $fields = $('.lscf_field .' + id);
        }
        else {
            $fields = $('.lscf_field');
        }
    }

    /**
    * Loop through all total shortcodes on page.
    */
    $(function() {
        $('.lscf_total').each(proc_totals);
    })

})(jQuery);
