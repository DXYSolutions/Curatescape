<?php 
/*
** Global navigation
*/
function mh_global_nav(){		
		return public_nav_main(array(
				'Home' => uri('/'), 
				'Stories' => uri('items/browse'), 
				'Tours' => uri('/tour-builder/tours/browse/')));
}

/*
** Get the correct logo for the page
** uses body class to differentiate between home, stealth-home, and other
*/
function mh_the_logo(){
	if ( ($bodyid='home') && ($bodyclass='public') ) {
	    return '<img src="'.mh_lg_logo_url().'" class="home" id="logo-img" alt="'.settings('site_title').'"/>';	
	}elseif( ($bodyid='home') && ($bodyclass='stealth-mode') ){
		return '<img src="'.mh_stealth_logo_url().'" class="stealth" id="logo-img" alt="'.settings('site_title').'"/>';		
	}else{
		return '<img src="'.mh_med_logo_url().'" class="inner" id="logo-img" alt="'.settings('site_title').'"/>';	
	}	
}

/* 
** Link to Random item 	
*/

function random_item_link(){
	$items = get_items(array('random' => 1), 1);
    $item = $items[0];
    return link_to($item, 'show', 'Show me a random story', array('id' => 'random-story-link'));
}


/*
** Global header
** includes nav, logo, search bar
** site title h1 is visually hidden but included for semantic purposes and screen readers
*/
function mh_global_header(){
	$html ='<h1 id="site-title" class="visuallyhidden">'.link_to_home_page().'</h1>';

    $html .= '<div id="mobile-logo-container" class="clearfix">';
    
    $html .= '<div id="logo">';
    $html .= link_to_home_page(mh_the_logo());
    $html .= '</div>';
    
    $html  .= '<div id="mobile-menu-button"><a class="icon-reorder"><span class="visuallyhidden"> Menu</span></a></div>';
    $html .= '</div>';
	
	
	$html .= '<div id="mobile-menu-cluster" class="active">';
	
	$html .= '<nav id="primary-nav">';
    $html .= '<ul class="navigation">';
    $html .= mh_global_nav(); 
    $html .= '</ul>';
    $html .= '</nav>';
    
    
    
    $html .= '<div id="search-wrap">';
	$html .= mh_simple_search($buttonText, $formProperties=array('id'=>'header-search'), $uri); 
	
    $html .= '</div>';
    
    $html .= random_item_link();
    
    $html .= '</div>'; // end mobile-menu-cluster
    
    return $html;	
	
}





/*
** Modified search form
** Adds HTML "placeholder" attribute
** Adds HTML "type" attribute
*/

function mh_simple_search($buttonText = null, $formProperties=array('id'=>'simple-search'), $uri = null)
{
    if (!$buttonText) {
        $buttonText = __('Search');
    }

    // Always post the 'items/browse' page by default (though can be overridden).
    if (!$uri) {
        $uri = apply_filters('simple_search_default_uri', uri('items/browse'));
    }

    $searchQuery = array_key_exists('search', $_GET) ? $_GET['search'] : '';
    $formProperties['action'] = $uri;
    $formProperties['method'] = 'get';
    $html  = '<form ' . _tag_attributes($formProperties) . '>' . "\n";
    $html .= '<fieldset>'. "\n\n";
    $html .= __v()->formText('search', $searchQuery, array('type'=>'search','name'=>'search','class'=>'textinput','placeholder'=>'Search stories'));
    $html .= __v()->formSubmit('submit_search', $buttonText);
    $html .= '</fieldset>' . "\n\n";

    // add hidden fields for the get parameters passed in uri
    $parsedUri = parse_url($uri);
    if (array_key_exists('query', $parsedUri)) {
        parse_str($parsedUri['query'], $getParams);
        foreach($getParams as $getParamName => $getParamValue) {
            $html .= __v()->formHidden($getParamName, $getParamValue);
        }
    }

    $html .= '</form>';
    return $html;
}


/*
** App Store links on homepage
*/
function mh_appstore_downloads(){
	if (get_theme_option('enable_app_links')){ 
	
		echo '<h2>Downloads</h2>';
		
		$ios_link = get_theme_option('ios_link');
		echo ($ios_link ? 
		'<a id="apple" class="app-store" href="'.$ios_link.'">
		iOS App Store
		</a> ':'');
		
		$android_link = get_theme_option('android_link');
		echo ($android_link ? 
		'<a id="android" class="app-store" href="'.$android_link.'">
		Google Play
		</a> ':'');
		
		if ( ($android_link != true) && ($ios_link !=true) ) echo "Coming Soon";
		
	}
}			


/*
** App Store links in footer
*/
function mh_appstore_footer(){
		if (get_theme_option('enable_app_links')){ 
					
			$ios_link = get_theme_option('ios_link');
			$android_link = get_theme_option('android_link');
			if (($ios_link != false) && ($android_link == false)) {
					echo 'Get the app for <a id="apple-text-link" class="app-store" href="'.$ios_link.'">iPhone</a>';
					}
			elseif (($ios_link == false) && ($android_link != false)) {
					echo 'Get the app for <a id="apple-text-link" class="app-store-footer" href="'.$android_link.'">Android</a>';
					}
			elseif (($ios_link != false)&&($android_link != false)) {
					echo 'Get the app for <a id="apple-text-link" class="app-store-footer" href="'.$ios_link.'">iPhone</a> and <a id="android-text-link" class="app-store-footer" href="'.$android_link.'">Android</a>';
					}
				else{
					echo 'Coming soon for iPhone and Android Devices';
					}	
		}			
}	

/*
** map figure on items/show.php
** uses Geolocation plugin data to create Google Map
** re-uses data to add custom links to Google Maps, Bing Maps (WindowsPhone-only) and Apple Maps (iOS-only)
** at the moment, these links only open a view of the lat-lon coordinates (no custom pins or query titles, etc)
** TODO: make the links open into a more useful view by incorporating query params
*/
function mh_item_map(){
	if (function_exists('geolocation_get_location_for_item')){ 
		$location = geolocation_get_location_for_item(get_current_item(), true);
	    if ($location) {
	    echo geolocation_public_show_item_map('100%', '20em');
	    
	        $lng = $location['longitude'];
	        $lat = $location['latitude'];
	        $zoom = ($location['zoom_level']) ? '&z='.$location['zoom_level'] : '';	
	        $title = (item('Dublin Core','Title')) ? ''.str_replace("&","and", html_entity_decode(item('Dublin Core','Title'))).'' : '';
	        $addr = ($location['address']) ? ' near '.str_replace("&","and", html_entity_decode($location['address'])).'' : '';
	        $query = ($title || $addr) ? '&q='.$title.$addr : ''; // this is not quite generalizable so we won't use it
	        $coords = $lat.','.$lng;        
	        
	        // Google Maps for all users
	        $link = '<a class="item-map-link" href="http://maps.google.com/maps?q='.$coords.$zoom.'">View in Google Maps</a>';
	        
	        if (strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone OS') !== false) { 
	        // + Apple Maps for iOS users
		        $link .= ' <a class="item-map-link" href="http://maps.apple.com/maps?ll='.$coords.$zoom.'">Open in iOS Maps</a>';
		        };
		        
	        if (strpos($_SERVER['HTTP_USER_AGENT'], 'Windows Phone OS') !== false) { 
	        // + Bing Maps for Windows Phone users
		        $link .= ' <a class="item-map-link" href="http://bing.com/maps/default.aspx?cp='.str_replace(',','~',$coords).str_replace('z','lvl',$zoom).'&v=2">Open in Bing Maps</a>';
		        };		        
	        
	        echo $link;
	         
	        }
	}           
}


/*
** author byline on items/show.php
*/
function mh_the_author(){
	if ((get_theme_option('show_author') == true) && (item('Dublin Core', 'Creator'))){
		$authors=item('Dublin Core', 'Creator', array('all'=>true));
		$total=count($authors);
		$index=1;
				
		$html='<span class="story-meta">By: ';
		foreach ($authors as $author){
		switch ($index){
			case ($total):
			$delim ='';
			break;

			case ($total-1):
			$delim =' <span class="amp">&amp;</span> ';
			break;	
			
			default:
			$delim =', ';
			break;						
		}		
		
		
			$html .= $author.$delim;
			$index++;
		}
		$html .='</span>';
		
		echo $html;
	}
}

/*
** Return the current page URL
*/
function mh_current_page() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}

/*
** Finds URLs in a given $string and
** Adds zero-width spaces after special characters (really, just slash and dot)
** This allows the long URLs to wrap more efficiently
** Handy for when URLs are breaking responsive page design
** Indended use: mh_wrappable_link(item_citation())
** ...might need some revision for other uses
*/
function mh_wrappable_link($string){		
	
	/* Find a URL in the $string and build the replacement */
	preg_match('/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/',$string, $matches);
	$origURL = $matches[0];	
	$newURL=$origURL;
		$newURL=preg_replace('/\//','/&#8203;', $newURL); //replace slash with slash + zero-width-space
		$newURL=preg_replace('/\./','.&#8203;', $newURL); //replace dot with dot + zero-width-space
	
	/* Apply the repalcement URL to the original string */
	$string=preg_replace('/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/',$newURL, $string);
	
	return $string;
} 


/*
** Custom item citation
*/
function mh_item_citation(){
	return mh_wrappable_link(item_citation());
}


/*
** Loop through and display image files
*/
function mh_item_images(){
	//===========================// ?>
	<script>
	function hideText(){
		jQuery(".fancybox-title").fadeOut();
	}	
	// checkWidth.js sets 'big' and 'small' body classes
	// FancyBox is used only when the body class is 'big'
	jQuery(".big .fancybox").fancybox({
        beforeShow: function () {
            if (this.title) {
                // Add caption close button
                this.title += '<a class="fancybox-hide-text" onclick="hideText()">Hide Text</a> ';
            }	            
        },
	    helpers : {
	         title: {
	            type: 'over'
	        },
	         overlay : {
	         	locked : false
	         	}
	    }
	});
	</script>    
	<?php //========================//
	echo '<h3><i class="icon-camera-retro"></i>Photos <span class="toggle">Show <i class="icon-chevron-right"></i></span></h3>';
	while ($file = loop_files_for_item()){
		if ($file->hasThumbnail()) {
			//
			$photoDesc = mh_normalize_special_characters(item_file('Dublin Core', 'Description'));
			$photoTitle = mh_normalize_special_characters(item_file('Dublin Core', 'Title'));
			$photoCaption= $photoTitle.': '.$photoDesc;
			$photoCaption = strip_tags($photoCaption);
			
			$html = '<div class="item-file-container">';
			
			$html .= ''.display_file($file, array('imageSize' => 'fullsize','linkAttributes'=>array('title'=>$photoCaption, 'class'=>'fancybox', 'rel'=>'group'),'imgAttributes'=>array('alt'=>$photoTitle) ) );
			
			$html .= ($photoTitle) ? '<h4 class="title video-title">'.$photoTitle.'</h4>' : '';	
			$html .= ($photoDesc) ? '<p class="description video-description">'.$photoDesc.'</p>' : '';	
			$html .= '</div>';
			
			echo $html;				
	
		} 
	}
}


/*
** Loop through and display audio files
** FYI: adding "controls" to html <audio> tag causes a 
** display error when used in combination w/ Fancybox 
** image viewer 
*/
function mh_audio_files(){
$audioTypes = array('audio/mpeg'); 
$myaudio = array(); 
	while ($file = loop_files_for_item()):
		$audioDesc = item_file('Dublin Core','Description');
		$audioTitle = item_file('Dublin Core','Title');
		$mime = item_file('MIME Type');
		
		if ( array_search($mime, $audioTypes) !== false ) {
			
			if ($index==0) echo '<h3><i class="icon-volume-up"></i>Audio <span class="toggle">Show <i class="icon-chevron-right"></i></span></h3><script>audiojs.events.ready(function() {var as = audiojs.createAll();});</script>';
			$index++;
			
			array_push($myaudio, $file);
				
			$html = '<div class="item-file-container">';
			$html .= '<audio>
			<source src="'.file_download_uri($file).'" type="audio/mpeg" />
			<h5 class="no-audio"><strong>Download Audio:</strong><a href="'.file_download_uri($file).'">MP3</a></h5>
			</audio>';
			$html .= ($audioTitle) ? '<h4 class="title audio-title sib">'.$audioTitle.' <i class="icon-info-sign"></i></h4>' : '';	
			$html .= ($audioDesc) ? '<p class="description audio-description sib">'.$audioDesc.'</p>' : '';	
			$html .= '</div>';
			echo $html;								
		}	
					
	endwhile; 
}


/*
** Loop through and display video files
** Please use H.264 video format
** Browsers that do not support H.264 will fallback to Flash
** We accept multiple H.264-related MIME-types because Omeka MIME detection is sometimes spotty
** But in the end, we always tell the browser they're looking at "video/mp4"
** Opera and Firefox are currently the key browsers that need flash here, but that may change
*/
function mh_video_files() {
	$videoIndex = 1;
	$videoTypes = array('video/mp4','video/mpeg','video/quicktime'); 
	$videoPoster = mh_poster_url();
	$videoJS = js('video-js/video.min');
	$videoSWF= '<script> _V_.options.flash.swf = "'. WEB_ROOT .'/themes/curatescape/javascripts/video-js/video-js.swf"</script>';
	$videoHeading = (($videoIndex==1) ? $videoJS.$videoSWF.'<h3><i class="icon-film"></i>Video <span class="toggle">Show <i class="icon-chevron-right"></i></span></h3>' : '');
	
	while(loop_files_for_item()): 
		$file = get_current_file();
		$videoMime = item_file("MIME Type");
		$videoFile = file_download_uri($file);
		$videoTitle = item_file('Dublin Core', 'Title');
		$videoClass = (($videoIndex==1) ? 'first' : 'not-first');
		$videoDesc = item_file('Dublin Core','Description');
		$videoTitle = item_file('Dublin Core','Title');
		
		if ( in_array($videoMime,$videoTypes) ){
			$html = $videoHeading;
			
			$html .= '<div class="item-file-container">';
			$html .= '<video width="640" height="360" id="video-'.$videoIndex.'" class="'.$videoClass.' video-js vjs-default-skin" controls poster="'.$videoPoster.'"  preload="auto" data-setup="{}">';
			$html .= '<source src="'.$videoFile.'" type="video/mp4">'; 
			$html .= '</video>';
			$html .= ($videoTitle) ? '<h4 class="title video-title sib">'.$videoTitle.' <i class="icon-info-sign"></i></h4>' : '';	
			$html .= ($videoDesc) ? '<p class="description video-description sib">'.$videoDesc.'</p>' : '';	
			$html .= '</div>';
			
			echo $html;	
			echo mh_video_ResponsifyVideoScript($videoIndex);
			$videoIndex++;
			}
	endwhile;	
}
/*
** Script to resize the video based on desired aspect ratio and browser viewport
** This basically iterates a separate action for each video (see mh_video_files() loop above),
** which is not very efficient, but having more than one video per record is not very common here
*/
function mh_video_ResponsifyVideoScript($videoIndex, $aspectRatio='360/640'){
	$script = '
	<script>
	    _V_("#video-'.$videoIndex.'").ready(function(){
	      var myVid = this; 
	      var aspectRatio = '.$aspectRatio.'; 
	      function resizeVideoJS'.$videoIndex.'(){
	        var width = document.getElementById(myVid.id).parentElement.offsetWidth;
	        myVid.width(width).height( width * aspectRatio );
	      }
	      resizeVideoJS'.$videoIndex.'();
	      window.onresize = resizeVideoJS'.$videoIndex.'; 
	    });
	</script>';
	
	return $script;	
	
}

/*
** Display subjects as links
** These links are hard to validate via W3 for some reason
*/
function mh_subjects(){
$subjects = item('Dublin Core', 'Subject', 'all');
		if (count($subjects) > 0){

	    	echo '<h3>Subjects</h3>';
	    	echo '<ul>';
	    	foreach ($subjects as $subject){
	    		$link = WEB_ROOT;
	    		$link .= htmlentities('/items/browse?term='); 
	    		$link .= rawurlencode($subject);
	    		$link .= htmlentities('&search=&advanced[0][element_id]=49&advanced[0][type]=contains&advanced[0][terms]=');
	    		$link .= rawurlencode($subject);
	    		$link .= htmlentities('&submit_search=Search');
		    	echo '<li><a href="'.$link.'">'.$subject.'</a></li>';
		    	}
		    echo '</ul>';

	    } 
}


/*
Display nav items for Simple Pages sidebar 
** (not currently very useful, but we might add some novel content later)
*/
function mh_sidebar_nav(){
	
	return '<ul>'.mh_global_nav().'</ul>';
	
}

//Display item relations
function mh_item_relations(){
		if (function_exists('item_relations_display_item_relations')){
			$item=get_current_item();
		    $subjectRelations = ItemRelationsPlugin::prepareSubjectRelations($item);
		    $objectRelations = ItemRelationsPlugin::prepareObjectRelations($item);
		    if ($subjectRelations || $objectRelations){
				echo '<h3>Related Stories</h3>';
				echo '<ul>';
				foreach ($subjectRelations as $subjectRelation){
				        	echo '<li><a href="'.uri('items/show/' . $subjectRelation['object_item_id']).'">'.$subjectRelation['object_item_title'].'</a></li>';
				        		}
				foreach ($objectRelations as $objectRelation){
				        	echo '<li><a href="'.uri('items/show/' . $objectRelation['subject_item_id']).'">'.$objectRelation['subject_item_title'].'</a></li>';
				        		}
			echo '</ul>';
			}		    
		}
}



/*
** Display the item tags
*/
function mh_tags(){		
		if (item_has_tags()): 
		
			echo '<h3>Tags</h3>';
		    echo item_tags_as_cloud(
			    $order = 'alpha', 
			    $tagsAreLinked = true, 
			    $item=null, 
			    $limit=null
		    );
		endif;
}

/*
** Display related links
*/
function mh_related_links(){
    $relations = item('Dublin Core', 'Relation', array('all' => true));
    if ($relations){
    echo '<h3>Related Sources</h3><ul>';
    	foreach ($relations as $relation) {
        	echo "<li>$relation</li>";
    		}
    echo '</ul>';		
    }	
}

/*
** Display the AddThis social sharing widgets
*/
function mh_share_this(){
	$addthis = (get_theme_option('Add This')) ? (get_theme_option('Add This')) : 'ra-4e89c646711b8856';
	
	$html = '<h3>Share this Page</h3>';
	$html .= '<div class="addthis_toolbox addthis_default_style addthis_32x32_style">
		<a class="addthis_button_preferred_1"></a>
		<a class="addthis_button_preferred_2"></a>
		<a class="addthis_button_preferred_3"></a>
		<a class="addthis_button_preferred_4"></a>
	</div>';
	
	$html .= '<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid='.$addthis.'"></script>';
	
	return $html;
}


/*
** Subnavigation for items/browse pages
*/

function mh_item_browse_subnav(){
			if (function_exists('subject_browse_public_navigation_items')){
			echo nav(array(
			'All' => uri('items/browse'), 
			'Tags' => uri('items/tags'), 
			'Subjects' => uri('items/subject-browse')
			));
			}
			else{
			echo nav(array(
			'All' => uri('items/browse'), 
			'Tags' => uri('items/tags')));
			} 	
}


/*
** See where you're at in a loop and conditionally load content
** This quirky little function is used mainly on items/browse, 
** where we need to output all item records (making for one hell of a page load when you have 500+ items)
** NOTE that you can only use this function within loops where $index is defined and incremented
*/
function mh_reducepayload($index,$showThisMany){
	$showThisMany = ($index) ? ($index < $showThisMany) : true;
	return $showThisMany;
}

/*
** Display the Tours list
*/
function mh_display_random_tours($num = 3){
	
    // Get the database.
    $db = get_db();

    // Get the Tour table.
    $table = $db->getTable('Tour');

    // Build the select query.
    $select = $table->getSelect();
    $select->from(array(), 'RAND() as rand');
    $select->where('public = 1');
	 
    // Fetch some items with our select.
    $items = $table->fetchObjects($select);
    shuffle($items);
    $num = (count($items)<$num)? count($items) : $num;
   
    echo '<h2>Take a Tour</h2>';
    
	for ($i = 0; $i < $num; $i++) {
    	echo '<article class="item-result">';
    	echo '<h3><a href="' . WEB_ROOT . '/tour-builder/tours/show/id/'. $items[$i]['id'].'">' . $items[$i]['title'] . '</a></h3><div class="item-description">'.snippet($items[$i]['description'],0,250,"...").'</div>';
    	echo '</article>';
	}
	
	echo '<p class="view-more-link"><a href="'.WEB_ROOT.'/tour-builder/tours/browse/">View All Tours</a></p>';
	
	return $items;
}

		
		

/*
** JSON tour list output
*/
function toursList() {
	// Start with an empty array of tours
	$all_tours_metadata = array();
	
	// Loop through all the tours
	while( loop_tours() ) {
	   $tour = get_current_tour();
	
	   $tour_metadata = array( 
	      'id'     => tour( 'id' ),
	      'title'  => tour( 'title' ),
	   );
	
	   array_push( $all_tours_metadata, $tour_metadata );
	}
	
	$metadata = array(
	   'tours'  => $all_tours_metadata,
	);
	
	// Encode and send
	echo Zend_Json_Encoder::encode( $metadata );
}

/*
** Display random featured item
** Used on homepage
*/
function mh_display_random_featured_item($withImage=false)
 {
    $featuredItem = random_featured_item($withImage);
 	$html = '<h2>Featured Story</h2>';
 	$html .= '<article class="item-result">';
 	if ($featuredItem) {
 	    $itemTitle = item('Dublin Core', 'Title', array(), $featuredItem);
        
 	  
 	   if (item_has_thumbnail($featuredItem)) {
 	       $html .= '<div class="item-thumb">' . link_to_item(item_fullsize(array(), 0, $featuredItem), array(), 'show', $featuredItem) . '</div>';
 	   }
 	   
 	   $html .= '<h3>' . link_to_item($itemTitle, array(), 'show', $featuredItem) . '</h3>';
 	   
 	   // Grab the 1st Dublin Core description field (first 150 characters)
 	   if ($itemDescription = item('Dublin Core', 'Description', array('snippet'=>550), $featuredItem)) {
 	       $html .= '<div class="item-description">' . strip_tags($itemDescription) . '</div>';
 	       }else{
 	       $html .= '<div class="item-description empty">Preview text not available.</div>';}
 	       
 	    $html .= '<p class="view-more-link">'. link_to_item('More about '.$itemTitle, array(), 'show', $featuredItem) .'</p>';   
       
 	}else {
 	   $html .= '<p>No featured items are available.</p>';
 	}
 	$html .= '</article>';

     return $html;
 }
 

/*
** Display the most recently added item
** Used on homepage
*/ 
function mh_display_recent_item($num=1){
		echo ($num <=1) ? '<h2>Newest Story</h2>' : '<h2>Newest Stories</h2>';
		set_items_for_loop(recent_items($num)); 
		if (has_items_for_loop()){ 
			while (loop_items()){
				echo '<article class="item-result">';
				
				echo '<h3>'.link_to_item().'</h3>';
								
				echo '<div class="item-thumb">'.link_to_item(item_square_thumbnail()).'</div>';
				
				
				if($desc = item('Dublin Core', 'Description', array('snippet'=>200))){ 
					echo '<div class="item-description">'.$desc.'</div>';
				}else{
					echo '<div class="item-description">Text preview unavailable.</div>';
					}
					
				echo '</article>';
				
				} 
			}
			echo '<p class="view-more-link">'.link_to_browse_items('View All Stories').'</p>';
} 

/*
** Display the customizable content on homepage
** Currently user may choose to display Twitter or About content
*/
function mh_about_home(){
			$html = '<h2 class="col-heading">About</h2>';
			$html .= get_theme_option('about');
			$html .= '';
			
			echo $html;
}

/*
** Csutom CSS
*/ 
function mh_custom_css(){
	return '<style type="text/css">
	a,blockquote{color:'.mh_link_color().'}'.get_theme_option('custom_css').
	'</style>';
}

/*
** Typekit script for header.php
*/
function mh_typekit(){
	if(get_theme_option('typekit')){
		$html ='<script type="text/javascript" src="http://use.typekit.com/'.get_theme_option('typekit').'.js"></script>';
		$html .='<script type="text/javascript">try{Typekit.load();}catch(e){}</script>';
		return $html;
		}
}

/*
** About text
** Used on homepage (stealth and public)
*/
function mh_about($text=null){
    if (!$text) {
        // If the 'About Text' option has a value, use it. Otherwise, use default text  
        $text = 
        get_theme_option('about') ?
        get_theme_option('about') : 
        'This site is powered by Omeka + MobileHistorical, a humanities-centered web and mobile framework available for both Android and iOS devices.';
    }
    return $text; 
}



/*
** Google Analytics
*/
function mh_google_analytics($webPropertyID=null){
	$webPropertyID= get_theme_option('google_analytics');
	if ($webPropertyID!=null){
	echo "<script type=\"text/javascript\">
	
	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', '".$webPropertyID."']);
	  _gaq.push(['_trackPageview']);
	
	  (function() {
	    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();
	
	</script>";
	}
}

/*
** Edit item link
*/
function link_to_item_edit()
{
$current = Omeka_Context::getInstance()->getCurrentUser();
        if ($current->role == 'super') {
                echo '<a class="edit" href="'. html_escape(uri('admin/items/edit/')).item('ID').'">Edit this item...</a>';
                }
        elseif($current->role == 'admin'){
                echo '<a class="edit" href="'. html_escape(uri('admin/items/edit/')).item('ID').'">Edit this item...</a>';
                }
} 

/*
** <video> placeholder image
*/
function mh_poster_url()
{
    $poster = get_theme_option('poster');
	
	$posterimg = $poster ? WEB_ROOT.'/archive/theme_uploads/'.$poster : img('poster.png');
	
	return $posterimg;
}

/*
** Stealth Mode logo
*/
function mh_stealth_logo_url()
{
    $stealth_logo = get_theme_option('stealth_logo');
	
	$logo_img = $stealth_logo ? WEB_ROOT.'/archive/theme_uploads/'.$stealth_logo : img('logo.png');
	
	return $logo_img;
}

/*
** Main logo
*/
function mh_lg_logo_url()
{
    $lg_logo = get_theme_option('lg_logo');
	
	$logo_img = $lg_logo ? WEB_ROOT.'/archive/theme_uploads/'.$lg_logo : img('hm-logo.png');
	
	return $logo_img;
}

/*
** Medium logo
*/
function mh_med_logo_url()
{
    $med_logo = get_theme_option('med_logo');
	
	$logo_img = $med_logo ? WEB_ROOT.'/archive/theme_uploads/'.$med_logo : img('lv-logo.png');
	
	return $logo_img;
}

/*
** Small logo
*/
function mh_nav_logo_url()
{
    $nav_logo = get_theme_option('tiny_logo');
	
	$logo_img = $nav_logo ? WEB_ROOT.'/archive/theme_uploads/'.$nav_logo : img('icn-sm.png');
	
	return $logo_img;
}

/*
** "Take a Tour" image file
*/
function mh_tour_logo_url()
{
    $tour_logo = get_theme_option('tour_logo');
	
	$logo_img = $tour_logo ? WEB_ROOT.'/archive/theme_uploads/'.$tour_logo : img('ttl-take-a-tour.png');
	
	return $logo_img;
}

/*
** "Follow the conversation" image file
*/
function mh_follow_logo_url()
{
    $follow_logo = get_theme_option('follow_logo');
	
	$logo_img = $follow_logo ? WEB_ROOT.'/archive/theme_uploads/'.$follow_logo : img('btn-conversation.png');
	
	return $logo_img;
}

/*
** Map pin file
*/
function mh_map_pin_logo_url()
{
    $map_pin_logo = get_theme_option('map_pin');
	
	$logo_img = $map_pin_logo ? WEB_ROOT.'/archive/theme_uploads/'.$map_pin_logo : img('icn.png');
	
	return $logo_img;
}

/*
** Icon file for iOS devices
** Used when the user saves a link to the website to their homescreen
** May also be used by other iOS apps, including a few RSS Readers (e.g. Reeder)
*/
function mh_apple_icon_logo_url()
{
    $apple_icon_logo = get_theme_option('apple_icon');
	
	$logo_img = $apple_icon_logo ? WEB_ROOT.'/archive/theme_uploads/'.$apple_icon_logo : img('Icon.png');
	
	return $logo_img;
}

/*
** Background image (home)
*/
function mh_bg_home_logo_url()
{
    $bg_home_logo = get_theme_option('bg_home');
	
	$logo_img = $bg_home_logo ? WEB_ROOT.'/archive/theme_uploads/'.$bg_home_logo : img('bg-home.jpg');
	
	return $logo_img;
}

/*
** Background image (not home)
*/
function mh_bg_lv_logo_url()
{
    $bg_lv_logo = get_theme_option('bg_lv');
	
	$logo_img = $bg_lv_logo ? WEB_ROOT.'/archive/theme_uploads/'.$bg_lv_logo : img('lv-bg.png');
	
	return $logo_img;
}

/*
** Custom link CSS color
*/
function mh_link_color()
{
    $color = get_theme_option('link_color');
	
	if ( ($color) && (preg_match('/^#[a-f0-9]{6}$/i', $color)) ){
		return $color;
	}
}

/*
** iOS App ID
** see mh_ios_smartbanner()
*/
function mh_app_id()
{
    $appID = (get_theme_option('ios_app_id')) ? get_theme_option('ios_app_id') : false;
    
    return $appID;
}

/*
** iOS Smart Banner
** Shown not more than once per day
*/
function mh_ios_smart_banner(){
	// show the iOS Smart Banner once per day if the app ID is set
	if (mh_app_id()!=false){
		$AppBanner = 'Curatescape_AppBanner_'.mh_app_id();
		if (!isset($_COOKIE[$AppBanner])){ 
		 echo '<meta name="apple-itunes-app" content="app-id='.mh_app_id().'">';
		 setcookie($AppBanner, true,  time()+86400); // 1 day
		}  
	}
}	

/*
** Twitter
*/

function  mh_link_my_tweet($text){
	$text= preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t< ]*)#", "\\1<a href=\"\\2\" target=\"_blank\">\\2</a>", $text);
	$text= preg_replace("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r< ]*)#", "\\1<a href=\"http://\\2\" target=\"_blank\">\\2</a>", $text);
	$text= preg_replace("/@(\w+)/", "<a href=\"http://www.twitter.com/\\1\" target=\"_blank\">@\\1</a>", $text);
	$text= preg_replace("/#(\w+)/", "<a href=\"http://search.twitter.com/search?q=\\1\" target=\"_blank\">#\\1</a>", $text);
	echo $text;
}


function mh_get_tweets(){

	 $twitte = file_get_contents("http://search.twitter.com/search.json?q=".get_theme_option('twitter_hashtag')."%20OR%20%23".get_theme_option('twitter_hashtag')."&amp;rpp=4");
	 $data = json_decode($twitte);
	 $o_text = "";
	 foreach($data->results as $item)
	 {
	 	$date = date('m/d/o',strtotime($item->created_at));
	 	echo "<li>";
	    $o_text = "<div class='date'><a href='https://twitter.com/#!/".get_theme_option('twitter_hashtag')."/status/". $item->id_str . "' target='_blank'>" .$date."</a> @". $item->from_user .": "."</div>".$item->text;
		 mh_link_my_tweet($o_text);
	
	   	//echo $o_text;
		   echo "</li>";
		 } 
 }
 
 function mh_follow_the_conversation(){
	 
	 $html .= '<a href="http://twitter.com/#!/search/'.(get_theme_option('twitter_hashtag') ? get_theme_option('twitter_hashtag') : get_theme_option('twitter_username')).'"><img src="'. mh_follow_logo_url().'" alt="Join the Conversation on Twitter" title="Join the Conversation on Twitter" /></a>';
	 return $html;
 }
 


/*
** Character normalization
** Used to strip away unwanted or problematic formatting
*/
function mh_normalize_special_characters( $str ) 
{ 
    # Quotes cleanup 
    $str = str_replace( chr(ord("`")), "'", $str );        # ` 
    $str = str_replace( chr(ord("´")), "'", $str );        # ´ 
    $str = str_replace( chr(ord("?")), ",", $str );        # ? 
    $str = str_replace( chr(ord("`")), "'", $str );        # ` 
    $str = str_replace( chr(ord("´")), "'", $str );        # ´ 
    $str = str_replace( chr(ord("?")), "\"", $str );        # ? 
    $str = str_replace( chr(ord("?")), "\"", $str );        # ? 
    $str = str_replace( chr(ord("´")), "'", $str );        # ´ 

    $unwanted_array = array(    '?'=>'S', '?'=>'s', '?'=>'Z', '?'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 
                                'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 
                                'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 
                                'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 
                                'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y'); 
                                
    $str = strtr( $str, $unwanted_array ); 
    
    #For reasons yet unknown, only some servers may require an additional $unwanted_array item: 'height'=>'h&#101;ight'

    # Bullets, dashes, and trademarks 
    $str = str_replace( chr(149), "&#8226;", $str );    # bullet ? 
    $str = str_replace( chr(150), "&ndash;", $str );    # en dash 
    $str = str_replace( chr(151), "&mdash;", $str );    # em dash 
    $str = str_replace( chr(153), "&#8482;", $str );    # trademark 
    $str = str_replace( chr(169), "&copy;", $str );    # copyright mark 
    $str = str_replace( chr(174), "&reg;", $str );        # registration mark 
    $str = str_replace( "&quot;", "\"", $str );        # "
    $str = str_replace( "&apos;", "\'", $str );        # '
    $str = str_replace( "&#039;", "'", $str );        # '

    return $str; 
} 

?>