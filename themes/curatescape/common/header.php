<!DOCTYPE html>
<!--[if lt IE 7 ]> <html lang="en"  class="ie ie6 lte9 lte8 lte7 no-js"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en"  class="ie ie7 lte9 lte8 lte7 no-js"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en"  class="ie ie8 lte9 lte8 no-js"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en"  class="ie ie9 lte9 no-js"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="notie no-js"> <!--<![endif]-->
<head>

<!-- Meta -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    
<title><?php echo settings('site_title'); echo $title ? ' | ' . $title : ''; ?></title>

<meta name="description" content="<?php echo settings('description'); ?>" />
<meta name="keywords" content="<?php echo get_theme_option('meta_key') ;?>" /> 
<meta name="viewport" content="width=device-width">
<link rel="shortcut icon" href="<?php echo img('favicon.ico');?>"/>
<?php echo auto_discovery_link_tag(); ?>

<!-- Apple Stuff -->
<link rel="apple-touch-icon-precomposed" href="<?php echo mh_apple_icon_logo_url();?>"/>
<?php echo mh_ios_smart_banner(); ?>


<?php 
// Are we viewing the item record? If so, queue up the following JS and CSS...
$itemsShow = ( ($bodyid == 'items') && ($bodyclass == 'show') ) ? true : false;
if($itemsShow){
	//queue_js('video-js/video.min'); // loaded via custom.php: mh_video_files()
	queue_js('audiojs/audiojs/audio.min');
	queue_js('fancybox/source/jquery.fancybox');
	queue_css('fancybox/source/jquery.fancybox', 'all', $conditional, 'javascripts');
	queue_css('video-js/video-js.min','all',$conditional,'javascripts');
}
// Are we viewing the stealth mode homepage? If so, queue up the following CSS...
$stealthHome = ( ($bodyid == 'home') && ($bodyclass == 'stealth-mode') ) ? true : false;
if($stealthHome){
	queue_css('stealth-screen');
}
?>

<!-- Stylesheets -->
<?php 
// also returns conditional styles from queue above
queue_css('screen');
queue_css('print','print');
display_css();
?>

<!-- Custom CSS via theme config -->
<?php echo mh_custom_css(); ?>

<!-- JavaScripts -->
<?php
// also returns conditional scripts from queue above
queue_js('modernizr'); 
queue_js('check-width');
display_js();
?>

<!-- TypeKit -->
<?php mh_typekit();?>

<!-- Google Analytics -->
<?php echo mh_google_analytics();?>

<!-- Plugin Stuff -->
<?php echo plugin_header(); ?>




</head>
<body<?php echo $bodyid ? ' id="'.$bodyid.'"' : ''; ?><?php echo $bodyclass ? ' class="'.$bodyclass.'"' : ''; ?>> 

<div id="no-js-message">
	<span>Please enable JavaScript in your browser settings.</span>
</div>

<div id="wrap">

	<header class="main">	
		<?php echo mh_global_header();?>
		<script>
		    jQuery("#mobile-menu-cluster").removeClass("active");
		    jQuery("#mobile-menu-button a").click(function () {
		      jQuery("#mobile-menu-cluster").toggleClass("active");
		    });
		</script>
	</header>

	
	
	<figure id="hero">
		<!--div id="hm-map">
			<div id="map_canvas">
				<?php echo geolocation_scripts(); ?>
	
				<div id="map-block">
				<h2 id="story-map" class="visuallyhidden">Story Map</h2>
					<?php echo geolocation_google_map('map-display', array('loadKml'=>true, 'list'=>'map-links'));?>
				</div>
	
				<div id="link_block" style="display:none;">
					<div id="map-links" style="display:none;"></div>
				</div>
				
			</div> 
		</div-->	
	</figure>
