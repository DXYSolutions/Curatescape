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


	<section id="downloads">
		<?php mh_appstore_downloads(); ?>
	</section> 

	<section id="home-tours">
		<h2>Take a Tour</h2>
		<?php mh_display_tour_items(); ?>
		<p class="view-items-link">
			<a href="<?php echo WEB_ROOT;?>/tour-builder/tours/browse/">More Tours</a>
		</p>
	</section>
	
	<section id="recent-story">
		<h2>Recently Added</h2>
		
		<?php mh_display_recent_item($num=1);?>
			
		<p class="view-items-link"><?php echo link_to_browse_items('View All Stories'); ?></p>
		
	</section>
		
		   
	<section id="featured-story"> 
		<?php echo mh_display_random_featured_item(true); ?>
	</section>		

		
	<section id="custom-column">
		<?php mh_custom_column_home();?>
	</section>	
		

</article>
</div> <!-- end content -->
<?php foot(); ?>

<?php
//end stealth mode else statement
 }?>