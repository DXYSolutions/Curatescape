<?php 

/** == Global navigation == **/
function mh_global_nav(){		
		return public_nav_main(array(
				'Home' => uri('/'), 
				'Stories' => uri('items'), 
				'Tours' => uri('/tour-builder/tours/browse/')));
}

/** == Get the correct logo for the page  == **/
function mh_the_logo(){
	if ( ($bodyid='home') && ($bodyclass='public') ) {
	    return '<img src="'.mh_lg_logo_url().'" class="home" id="logo-img"/>';	
	}elseif( ($bodyid='home') && ($bodyclass='stealth-mode') ){
		return '<img src="'.mh_stealth_logo_url().'" class="stealth" id="logo-img"/>';		
	}else{
		return '<img src="'.mh_med_logo_url().'" class="inner" id="logo-img"/>';	
	}	
}

/* == Global Header == **/
function mh_global_header(){
	$html ='<h1>'.link_to_home_page().'</h1>';
	
	$html .= '<nav id="primary-nav">';
    $html .= '<ul class="navigation">';
    $html .= mh_global_nav(); 
    $html .= '</ul>';
    $html .= '</nav>';
    
    $html .= '<div id="search-wrap">';
	$html .= simple_search(); 
    $html .= '</div>';
    
    $html .= '<div id="logo">';
    $html .= link_to_home_page(mh_the_logo());
    $html .= '</div>';
    
    return $html;	
	
}

// * == App store links on home == * //
function mh_appstore_downloads(){
	if (get_theme_option('enable_app_links')){ 
	
		echo '<header><h2>Downloads</h2></header>';
		
		$ios_link = get_theme_option('ios_link');
		echo ($ios_link ? 
		'<a id="apple" class="app-store" href="'.$ios_link.'">
			<img src="'.img('app-store-badge.gif').'" alt="iPhone App Store" />
		</a>':'');
		
		$android_link = get_theme_option('android_link');
		echo ($android_link ? 
		'<a id="android" class="app-store" href="'.$android_link.'">
			<img src="'.img('btn-android.png').'" alt="Google Play App Store" >
		</a>':'');
		
		if ( ($android_link != true) && ($ios_link !=true) ) echo "Coming Soon";
		
	}
}			


// * == App store links in footer == * //
function mh_appstore_footer(){
		if (get_theme_option('enable_app_links')){ 
					
			$ios_link = get_theme_option('ios_link');
			$android_link = get_theme_option('android_link');
			if (($ios_link != false)||($android_link != false)) echo "Get the app: ";
			
			echo ($ios_link ? 
			'<a id="apple" class="app-store" href="'.$ios_link.'">iPhone</a> ':'');
			
			
			echo ($android_link ? 
			'<a id="android" class="app-store" href="'.$android_link.'">Android</a> ':'');
							
		}
}	

//Display map on item/show
function mh_item_map(){
if (function_exists('geolocation_get_location_for_item')){ 
		    $location = geolocation_get_location_for_item($item, true);
			$lng  = (double) $location['longitude'];
            $lat  = (double) $location['latitude'];
            echo geolocation_public_show_item_map();
            echo '<a target="_blank" href="http://maps.google.com/maps?q='.$lat.','.$lng.'">View in Google Maps</a></li>'; }           
}
//Display item images
function mh_item_images(){
	echo '<h3>Photos</h3>';
	while ($file = loop_files_for_item()):
			if ($file->hasThumbnail()) {
				//
				$query = item_file('Dublin Core', 'Description');
				$query = preg_replace("/(<br\s*\/?>\s*)+/", "<br><br>", $query); // remove excess <br> tags!
				$photoDesc = mh_normalize_special_characters($query);
				//
				$query = item_file('Dublin Core', 'Title');
				$photoTitle = mh_normalize_special_characters($query); 
				//
				echo display_file($file, array('linkAttributes'=>array('rel'=>'clearbox[gallery=Photo Gallery,,comment='.$photoDesc.',,title='.$photoTitle.']')));
		
			} else {
			// do something with non-images here?
			}
	endwhile; 
}


// Loop through and display audio files
function mh_audio_files(){
$audioTypes = array('audio/mpeg'); 
$myaudio = array(); 
	while ($file = loop_files_for_item()):
		$mime = item_file('MIME Type');
		
		//echo $mime;

		if ( array_search($mime, $audioTypes) !== false ) {
			
			if ($index==0) echo '<h3>Audio Files</h3>';
			$index++;
			
			array_push($myaudio, $file);
			

		echo '<p><span class="audio-title">'.item_file('Dublin Core', 'Title').'</span><br/><span class="audio-caption">'.item_file('Dublin Core', 'Description').'</span></p>';
	

		$msie = strpos($_SERVER["HTTP_USER_AGENT"], 'MSIE') ? true : false; 
		$firefox = strpos($_SERVER["HTTP_USER_AGENT"], 'Firefox') ? true : false;
		$safari = strpos($_SERVER["HTTP_USER_AGENT"], 'Safari') ? true : false;
		$chrome = strpos($_SERVER["HTTP_USER_AGENT"], 'Chrome') ? true : false;
		$opera = strpos($_SERVER["HTTP_USER_AGENT"], 'Opera') ? true : false;



		if (($firefox == 'true')||($msie == 'true')||($opera == 'true')){
			
			//do something with flash or something
		
		} else {
		// html5 audio for browsers that can play mp3s
		echo '<audio controls="controls">
			<source src="'.file_download_uri($file).'" type="audio/mpeg" />
			<h5 class="no-audio"><strong>Download Audio:</strong><a href="'.file_download_uri($file).'">MP3</a></h5>
			</audio>';
				}
		}
						
	endwhile; 
}


//Display video files
function mh_video_files() {
	$videoIndex = 1;
	$videoTypes = array('video/mp4','video/mpeg','video/quicktime');
	$videoPoster = mh_poster_url();
	
	while(loop_files_for_item()): 
		$file = get_current_file();
		$videoMime = item_file("MIME Type");
		$videoFile = file_download_uri($file);
		$videoTitle = item_file('Dublin Core', 'Title');
		$videoClass = (($videoIndex==1) ? 'first' : 'not-first');
				
		
		if ( in_array($videoMime,$videoTypes) ){
			$html = '<video width="100%" height="auto" id="video-'.$videoIndex.'" controls="controls" poster="'.$videoPoster.'" class="'.$videoClass.'">';
			$html .= '<source src="'.$videoFile.'" type="'.$videoMime.'">';
			$html .= '</video>';	
			echo $html;	
			$videoIndex++;
			}
	endwhile;
}

//Display subjects as links
function mh_subjects(){
$subjects = item('Dublin Core', 'Subject', 'all');
		if (count($subjects) > 0){

	    	echo '<h3>Subject</h3>';
	    	echo '<div class="subjects"><ul>';
	    	foreach ($subjects as $subject){
		    	echo '<li>';
		    	echo '<a href="'.WEB_ROOT.'/items/browse?search=&advanced[0][element_id]=49&advanced[0][type]=contains&advanced[0][terms]='.$subject.'&submit_search=Search">'.$subject.'</a>';
		    	echo '</li>';
		    	}
		    echo '</ul></div>';

	    } 
}


//Display nav items for Simple Pages sidebar (not currently very useful, but we might add some novel content later)
function mh_sidebar_nav(){
	
	return mh_global_nav();
	
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



//Display the item tags
function mh_tags(){		
		if (item_has_tags()): 
		
			echo '<h3>Tags</h3>';
		    echo item_tags_as_string(
	    		$delimiter = ', ', 
	    		$order = 'alpha', 
	   			$tagsAreLinked = true, 
	   	 		$item=null, 
	    		$limit=null);
		endif;
}

//Display related links
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


/** -- GET THE TOUR LIST -- **/
function mh_display_tour_items($num = 15){
	
    // Get the database.
    $db = get_db();

    // Get the Tour table.
    $table = $db->getTable('Tour');

    // Build the select query.
    $select = $table->getSelect();
    $select->from(array(), 'RAND() as rand');
    $select->where('public = 1');
    $select->order('title ASC');
    $select->limit($num);    
	 
    // Fetch some items with our select.
    $items = $table->fetchObjects($select);
    
   // echo count($items);
    $tot = count($items);
   
    echo "<ul>";
    
	for ($i = 0; $i < $tot; $i++) {
    	echo "<li><a href='" . WEB_ROOT . "/tour-builder/tours/show/id/". $items[$i]['id']."'>" . $items[$i]['title'] . "</a></li>";
	}
	echo "</ul>";
	
	return $items;
}

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


function mh_display_random_featured_item($withImage=false)
 {
    $featuredItem = random_featured_item($withImage);
 	$html = '<h2 class="col-heading">Featured Story</h2>';
 	if ($featuredItem) {
 	    $itemTitle = item('Dublin Core', 'Title', array(), $featuredItem);
        
 	  
 	   if (item_has_thumbnail($featuredItem)) {
 	       $html .= '<div class="thumb">' . link_to_item(item_square_thumbnail(array(), 0, $featuredItem), array('class'=>'image'), 'show', $featuredItem) . '</div>';
 	   }
 	   
 	   $html .= '<h3>' . link_to_item($itemTitle, array(), 'show', $featuredItem) . '</h3>';
 	   
 	   // Grab the 1st Dublin Core description field (first 150 characters)
 	   if ($itemDescription = item('Dublin Core', 'Description', array('snippet'=>150), $featuredItem)) {
 	       $html .= '<p class="item-description">' . $itemDescription . '</p><p class="view-items-link">'. link_to_item('More about '.$itemTitle, array(), 'show', $featuredItem) .'</p>';
       }
 	} else {
 	   $html .= '<p>No featured items are available.</p>';
 	}

     return $html;
 }
 
function mh_display_recent_item($withImage=false)
 {
    $recentItem = set_items_for_loop(recent_items(1));
 	$html = '<h2>Recently Added</h2>';
 	if ($recentItem) {
 	    $itemTitle = item('Dublin Core', 'Title', array(), $recentItem);
        
 	   $html .= '<h3>' . link_to_item($itemTitle, array(), 'show', $recentItem) . '</h3>';
 	   if (item_has_thumbnail($recentItem)) {
 	       $html .= '<div class="thumb">' . link_to_item(item_square_thumbnail(array(), 0, $recentItem), array('class'=>'image'), 'show', $recentItem) . '</div>';
 	   }
 	   // Grab the 1st Dublin Core description field (first 150 characters)
 	   if ($itemDescription = item('Dublin Core', 'Description', array('snippet'=>150), $recentItem)) {
 	       $html .= '<p>' . $itemDescription . '</p>';
       }
 	} else {
 	   $html .= '<p>No featured items are available.</p>';
 	}
     return $html;
 }
 
function mh_custom_css(){
	return '<style type="text/css">
	a, a:link {color:'.mh_link_color().'}'.get_theme_option('custom_css').
	'</style>';
}

function mh_typekit(){
	if(get_theme_option('typekit')){
		$html ='<script type="text/javascript" src="http://use.typekit.com/'.get_theme_option('typekit').'.js"></script>';
		$html .='<script type="text/javascript">try{Typekit.load();}catch(e){}</script>';
		return $html;
		}
}

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

function mh_poster_url()
{
    $poster = get_theme_option('poster');
	
	$posterimg = $poster ? WEB_ROOT.'/archive/theme_uploads/'.$poster : img('poster.jpg');
	
	return $posterimg;
}

function mh_stealth_logo_url()
{
    $stealth_logo = get_theme_option('stealth_logo');
	
	$logo_img = $stealth_logo ? WEB_ROOT.'/archive/theme_uploads/'.$stealth_logo : img('logo.png');
	
	return $logo_img;
}

function mh_lg_logo_url()
{
    $lg_logo = get_theme_option('lg_logo');
	
	$logo_img = $lg_logo ? WEB_ROOT.'/archive/theme_uploads/'.$lg_logo : img('hm-logo.png');
	
	return $logo_img;
}

function mh_med_logo_url()
{
    $med_logo = get_theme_option('med_logo');
	
	$logo_img = $med_logo ? WEB_ROOT.'/archive/theme_uploads/'.$med_logo : img('lv-logo.png');
	
	return $logo_img;
}

function mh_nav_logo_url()
{
    $nav_logo = get_theme_option('tiny_logo');
	
	$logo_img = $nav_logo ? WEB_ROOT.'/archive/theme_uploads/'.$nav_logo : img('icn-sm.png');
	
	return $logo_img;
}

function mh_tour_logo_url()
{
    $tour_logo = get_theme_option('tour_logo');
	
	$logo_img = $tour_logo ? WEB_ROOT.'/archive/theme_uploads/'.$tour_logo : img('ttl-take-a-tour.png');
	
	return $logo_img;
}

function mh_follow_logo_url()
{
    $follow_logo = get_theme_option('follow_logo');
	
	$logo_img = $follow_logo ? WEB_ROOT.'/archive/theme_uploads/'.$follow_logo : img('btn-conversation.png');
	
	return $logo_img;
}

function mh_map_pin_logo_url()
{
    $map_pin_logo = get_theme_option('map_pin');
	
	$logo_img = $map_pin_logo ? WEB_ROOT.'/archive/theme_uploads/'.$map_pin_logo : img('icn.png');
	
	return $logo_img;
}

function mh_apple_icon_logo_url()
{
    $apple_icon_logo = get_theme_option('apple_icon');
	
	$logo_img = $apple_icon_logo ? WEB_ROOT.'/archive/theme_uploads/'.$apple_icon_logo : img('Icon.png');
	
	return $logo_img;
}

function mh_bg_home_logo_url()
{
    $bg_home_logo = get_theme_option('bg_home');
	
	$logo_img = $bg_home_logo ? WEB_ROOT.'/archive/theme_uploads/'.$bg_home_logo : img('bg-home.jpg');
	
	return $logo_img;
}

function mh_bg_lv_logo_url()
{
    $bg_lv_logo = get_theme_option('bg_lv');
	
	$logo_img = $bg_lv_logo ? WEB_ROOT.'/archive/theme_uploads/'.$bg_lv_logo : img('lv-bg.png');
	
	return $logo_img;
}

function mh_link_color()
{
    $color = get_theme_option('link_color');
	
	if ( ($color) && (preg_match('/^#[a-f0-9]{6}$/i', $color)) ){
		return $color;
	}
}

/*TWITTER*/

function  mh_link_my_tweet($text){
	$text= preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t< ]*)#", "\\1<a href=\"\\2\" target=\"_blank\">\\2</a>", $text);
	$text= preg_replace("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r< ]*)#", "\\1<a href=\"http://\\2\" target=\"_blank\">\\2</a>", $text);
	$text= preg_replace("/@(\w+)/", "<a href=\"http://www.twitter.com/\\1\" target=\"_blank\">@\\1</a>", $text);
	$text= preg_replace("/#(\w+)/", "<a href=\"http://search.twitter.com/search?q=\\1\" target=\"_blank\">#\\1</a>", $text);
	echo $text;
}


function mh_get_tweets(){

	 $twitte = file_get_contents("http://search.twitter.com/search.json?q=".get_theme_option('twitter_hashtag')."%20OR%20%23".get_theme_option('twitter_hashtag')."&rpp=4");
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
 
 /*UNWANTED CHARACTER STRIPPING */
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
                                'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y','&amp;'=>'&','height'=>'h&#101;ight' ); 
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