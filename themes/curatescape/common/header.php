<!DOCTYPE html>
<!--[if lt IE 7 ]> <html class="ie ie6 lte9 lte8 lte7 no-js"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie ie7 lte9 lte8 lte7 no-js"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie ie8 lte9 lte8 no-js"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie ie9 lte9 no-js"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html class="notie no-js"> <!--<![endif]-->
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

<?php 
// Are we viewing the item record? If so, queue up the following JS and CSS...
$itemsShow = ( ($bodyid == 'items') && ($bodyclass == 'show') ) ? true : false;
if($itemsShow){
	queue_js('video-js/video.min');
	queue_js('audiojs/audiojs/audio.min');
	queue_css('video-js/video-js.min',$media,$conditional,'javascripts');
}
// Are we viewing the stealth mode homepage? If so, queue up the following CSS...
$stealthHome = ( ($bodyid == 'home') && ($bodyclass == 'stealth-mode') ) ? true : false;
if($stealthHome){
	queue_css('stealth-screen');
}
?>

<!-- Stylesheets -->
<?php 
queue_css('screen');
queue_css('print','print');
display_css();
?>

<!-- Custom CSS via theme config -->
<?php echo mh_custom_css(); ?>

<!-- JavaScripts -->
<?php 
queue_js('modernizr'); 
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

<header>
<?php echo mh_global_header();?>
</header>