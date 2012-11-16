<?php head(array('bodyid'=>'items','bodyclass'=>'show','title' => item('Dublin Core', 'Title'))); ?>
<div id="content">
<article class="story item show">
<h1 class="item-title"><?php echo item('Dublin Core', 'Title'); ?></h1>
<?php mh_the_author();?>

	
	<div id="primary" class="show">
		<section id="text">
			<figure id="item-map">
			<?php mh_item_map();?>
			</figure>
			<div class="item-description">
			<h3>Description</h3>
			<?php echo item('Dublin Core', 'Description');?>
			</div>
			<?php echo link_to_item_edit();?>
		</section>
	</div><!-- end primary -->


	<div id="page-col-right">
		<section class="meta">
			<figure id="item-photos">
			<?php mh_item_images();?>
			</figure>
			
			<figure id="item-video" >
			<?php mh_video_files();?>
			</figure> 		
			
			<figure id="item-audio">
			<?php mh_audio_files();?>
			</figure>		
		</section>
	</div>

	<div id="page-col-left" class="item">
		<section class="meta">
			<div id="subjects">  	
			<?php mh_subjects(); ?>
			</div>	
			
			<div id="tags">
			<?php mh_tags();?>	
			</div>
			
			<div class="item-related-links">
			<?php /*DC: Relation field*/ mh_related_links();?>
			</div>
			
			<div id="relations">
			<?php /* Item Relations plugin */ mh_item_relations();?>			
			</div>
						
			<div id="cite-this">
			<h3>Cite this Page</h3>
			<?php echo item_citation(); ?>
			</div>	
			
			<div id="share-this">
			<?php echo mh_share_this();?>
			</div>			
		</section>	
		
	</div>	
	

</article>
</div> <!-- end content -->
<?php foot(); ?>