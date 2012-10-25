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
		<div id="map_canvas">
			<?php echo geolocation_scripts(); ?>
			
			<div id="map-block">
			    <?php echo geolocation_google_map('map-display', array('loadKml'=>true, 'list'=>'map-links'));?>
			</div><!-- end map_block -->
			
			<div id="link_block" style="display:none;">
			    <div id="map-links" style="display:none;"></div><!-- Used by JavaScript -->
			</div>
		</div> 
	</figure>


	<section id="downloads">
		<?php mh_appstore_downloads(); ?>
	</section> 

	<section id="home-tours">
		<img src="<?php echo mh_tour_logo_url(); ?>" alt="Take a Tour" title="Take a Tour"/>
		<?php mh_display_tour_items(); ?>
		<p class="view-items-link">
			<a href="<?php echo WEB_ROOT;?>/tour-builder/tours/browse/">More Tours</a>
		</p>
	</section>
	
	<section id="recent-story">
		<h2>Recently Added</h2>
		<?php 
		set_items_for_loop(recent_items(1)); 
		if (has_items_for_loop()){ 
			while (loop_items()){
				echo '<div class="itemthumb">'.link_to_item(item_square_thumbnail()).'</div>';
				echo '<h3>'.link_to_item().'</h3>';
				if($desc = item('Dublin Core', 'Description', array('snippet'=>150))){ 
					echo '<div class="item-description">'.$desc.'</div>';
				} else{ 
				echo '<p>No recent items available.</p>';
				} 
			}
		}
		?>
		<p class="view-items-link"><?php echo link_to_browse_items('View All Stories'); ?></p>
	</section>
		
		
	<section id="center-column">
		<?php 
		if ( (get_theme_option('twitter_username')!=false) && (get_theme_option('home_column')!=='about')) {
			echo '<h2>What Users Are Saying</h2>';
			echo '<div id="twitter">';
				echo '<ul>'.mh_get_tweets().'</ul>';
			echo '</div>';
			echo mh_follow_the_conversation(); 
		 }else{
			echo '<h2 class="col-heading">About</h2><p id="about">'.get_theme_option('about').'</p>';
			}?>
	</section>		
		
	   
	<section id="featured-story"> 
		<?php echo mh_display_random_featured_item(true); ?>
	</section>		
		

</article>
</div> <!-- end content -->
<?php foot(); ?>

<?php
//end stealth mode else statement
 }?>