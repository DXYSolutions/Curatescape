<?php head(array('bodyid'=>'items','bodyclass'=>'show','title' => item('Dublin Core', 'Title'))); ?>


<div id="content">

<article class="story item show">

			
	<header id="story-header">
	<h2 class="item-title instapaper_title"><?php echo item('Dublin Core', 'Title'); ?></h2>
	<?php mh_the_author();?>
	</header>


	<figure id="item-map">
	<?php mh_item_map();?>
	</figure>

	
	<div id="item-primary" class="show">
		<section id="text">

			<div class="item-description instapaper_body">
			<h3>Description</h3>
			<?php echo item('Dublin Core', 'Description');?>
			</div>
			<?php echo link_to_item_edit();?>
		</section>
	</div><!-- end primary -->

		
	<div id="section-container-bottom">
		<div class="section-container-inner">
		<div id="item-media">
			<section class="meta">
				<figure id="item-video" >
				<?php mh_video_files();?>
				</figure> 		
				
				<figure id="item-audio">
				<?php mh_audio_files();?>		
				</figure>	
				
				<figure id="item-photos">
				<?php mh_item_images();?>
				</figure>	
			</section>
		</div>
		</div>
	</div>	
	
		<div id="item-metadata" class="item">
			<section class="meta">
				<div id="subjects">  	
				<?php mh_subjects(); ?>
				</div>	
				
				<div id="tags">
				<?php mh_tags();?>	
				</div>
				
				<div id="relations">
				<?php /* Item Relations plugin */ mh_item_relations();?>			
				</div>
							
				<div id="cite-this">
				<h3>Cite this Page</h3>
				<?php echo mh_item_citation(); ?>
				</div>	
				
				<div id="share-this">
				<?php echo mh_share_this();?>
				</div>		
	
				<div class="item-related-links">
				<?php /*DC: Relation field*/ mh_related_links();?>
				</div>				
			</section>	
			
		</div>	
		


</article>
</div> <!-- end content -->
<?php foot(); ?>