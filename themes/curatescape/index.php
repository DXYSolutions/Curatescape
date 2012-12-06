<?php
if ((get_theme_option('stealth_mode')==1)&&(has_permission('Items', 'edit')!==true)){
include_once('stealth-index.php');
}
else{
//if not stealth mode, do everything else
?>

<?php head(array('bodyid'=>'home','bodyclass'=>'public')); ?>
<div id="content">
<article id="homepage">
		
	<figure id="home-map">
		<div id="hm-map">
			<div id="map_canvas">
				<?php echo geolocation_scripts(); ?>

				<div id="map-block">
				<h2 id="story-map" class="visuallyhidden">Story Map</h2>
					<?php echo geolocation_google_map('map-display', array('loadKml'=>true, 'list'=>'map-links'));?>
				</div>

				<div id="link_block" style="display:none;">
					<div id="map-links" style="display:none;"></div><!-- Used by JavaScript -->
				</div>
				
			</div> 
		</div>

	</figure>

	<div id="section-container">
		
	<div id="section-container-top">
		<div class="section-container-inner">
		
			<section id="recent-story">
				<?php mh_display_recent_item(3);?>
			</section>
				
			<section id="featured-story"> 
				<?php echo mh_display_random_featured_item(true); ?>
			</section>	
				
		</div>
	</div>
	
	<div id="section-container-bottom">	
		<div class="section-container-inner">	
		
			<section id="home-tours">
				<?php mh_display_random_tours(); ?>
			</section>
						
			<section id="custom-column">						
				<?php mh_custom_column_home();?>
			</section>	
	
			<section id="downloads">
				<?php mh_appstore_downloads(); ?>
			</section> 	
		
		</div>
	</div>	
	
	</div>

	
</article>
</div> <!-- end content -->

<?php foot(); ?>

<?php
//end stealth mode else statement
 }?>