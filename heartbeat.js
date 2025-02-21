(function($) {
    $(document).ready(function() {

        // Send data with heartbeat.
        $(document).on('heartbeat-send', function(event, data) {
            data.my_custom_data = 'custom_value';
        });

        // Handle response from heartbeat.
        $(document).on('heartbeat-tick', function(event, data) {
            if (!data.custom_value_hashed) {
                return;
            }
            alert('The hash is ' + data.custom_value_hashed);
        });

    });
})(jQuery);
