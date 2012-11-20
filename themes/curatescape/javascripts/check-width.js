jQuery(document).ready(function() {
    var $window = jQuery(window);

        // Function to handle changes to style classes based on window width
        function checkWidth() {
        if ($window.width() < 720) {
            jQuery('body').removeClass('big').addClass('small');
            };

        if ($window.width() >= 720) {
            jQuery('body').removeClass('small').addClass('big');
        }
    }

    // Execute on load
    checkWidth();

    // Bind event listener
        jQuery($window).resize(checkWidth);
});