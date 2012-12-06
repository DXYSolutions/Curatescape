jQuery(document).ready(function() {
    var $window = jQuery(window);
    
        // Function to handle changes to style classes based on window width
        // Also swaps in thumbnails for larger views where user can utilize Fancybox image viewer
        
        function checkWidth() {
        var breakpoint = 705;
        if ($window.width() < breakpoint) {
            jQuery('body').removeClass('big').addClass('small');
            jQuery(".item-file img").attr("src", function() { 
            	return this['src'].replace('square_thumbnails','fullsize'); 
            	});     
            jQuery("#item-photos .description , #item-photos .title").show();       
            };

        if ($window.width() >= breakpoint) {
            jQuery('body').removeClass('small').addClass('big');
            jQuery(".item-file img").attr("src", function() { 
            	return this['src'].replace('fullsize','square_thumbnails'); 
            	});
            jQuery("#item-photos .description , #item-photos .title").hide();
        }
    }

    // Execute on load
    checkWidth();

    // Bind event listener
        jQuery($window).resize(checkWidth);
});