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
		

			<section id="recent-story">
				<?php mh_display_recent_item(3);?>
			</section>
				
			<section id="featured-story"> 
				<?php echo mh_display_random_featured_item(true); ?>
			</section>	
				

		
			<section id="home-tours">
				<?php mh_display_random_tours(); ?>
			</section>
						
			<section id="about-text">						
				<?php mh_about_home();?>
			</section>	
	
			<section id="downloads">
				<?php mh_appstore_downloads(); ?>
			</section> 	


	
</article>
</div> <!-- end content -->

<?php foot(); ?>

<?php
//end stealth mode else statement
 }?>