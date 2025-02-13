jQuery(document).ready(function($) {
    // Get the saved direction from the localized script
    var savedDirection = direction_tgl_vars.direction;

    // Set the initial direction
    $('html').attr('dir', savedDirection);
    $('body').toggleClass('rtl', savedDirection === 'rtl');

    // Apply initial layout adjustments
    adjustLayout(savedDirection);

    // Toggle direction when the button is clicked
    $('#wp-admin-bar-direction_tgl_button a').on('click', function(e) {
        e.preventDefault();

        // Toggle the direction
        var currentDirection = $('html').attr('dir');
        var newDirection = (currentDirection === 'rtl') ? 'ltr' : 'rtl';
        $('html').attr('dir', newDirection);
        $('body').toggleClass('rtl', newDirection === 'rtl');

        // Adjust the layout
        adjustLayout(newDirection);

        // Send AJAX request to save the direction preference
        $.post(direction_tgl_vars.ajax_url, {
            action: 'direction_tgl_toggle',
            direction: newDirection,
            _ajax_nonce: direction_tgl_vars.nonce
        });
    });

    // Function to adjust the layout based on the direction
    function adjustLayout(direction) {
        if (direction === 'rtl') {
            // RTL adjustments
            $('#adminmenuback').css({
                'right': '0',
                'left': 'auto'
            });
            $('#adminmenuwrap').css({
                'right': '0',
                'left': 'auto'
            });
            $('#wpcontent, #wpfooter').css({
                'margin-right': '160px', // Width of the admin menu
                'margin-left': '0'
            });
        } else {
            // LTR adjustments
            $('#adminmenuback').css({
                'left': '0',
                'right': 'auto'
            });
            $('#adminmenuwrap').css({
                'left': '0',
                'right': 'auto'
            });
            $('#wpcontent, #wpfooter').css({
                'margin-left': '160px', // Width of the admin menu
                'margin-right': '0'
            });
        }
    }
});