jQuery(document).ready(function() {
    var $window = jQuery(window);
    
        // Function to handle changes to style classes based on window width
        // Also swaps in thumbnails for larger views where user can utilize Fancybox image viewer
        // Also swaps #hero images in items/show header
        
        function checkWidth() {
        var breakpoint = 720;
        if ($window.width() < breakpoint) {
            jQuery('body').removeClass('big').addClass('small');
            jQuery(".item-file img").attr("src", function() { 
            	return this['src'].replace('square_thumbnails','fullsize'); 
            	});     
            jQuery("#item-photos .description , #item-photos .title").show();
        	
        	//find the first image for the item and set it as the background to the #hero div
			if (jQuery("body#items").hasClass('show small')){
			    var imageUrl= jQuery("#item-photos .item-file img").attr('src');
			    var styles = {
			      'background-image' : 'url(' + imageUrl + ')',
			      'background-size' : 'cover',
			      'background-position' : 'center top'
			      }
				jQuery('#hero').css(styles); 
			}        
        };

        if ($window.width() >= breakpoint) {
            jQuery('body').removeClass('small').addClass('big');
            jQuery(".item-file img").attr("src", function() { 
            	return this['src'].replace('fullsize','square_thumbnails'); 
            	});
            jQuery("#item-photos .description , #item-photos .title").hide();
        	
        	//swaps image background in the #hero div
			if (jQuery("body#items").hasClass('show big')){
			    var imageUrl= '/themes/curatescape/images/placeholder.png';
			    var styles = {
			      'background-image' : 'url(' + imageUrl + ')',
			      'background-size' : 'auto',
			      'background-position' : 'center center'
			      }
				jQuery('#hero').css(styles); 
				}              
        }
    }

    // Execute on load
    checkWidth();

    // Bind event listener
    jQuery($window).resize(checkWidth);	        
             
});