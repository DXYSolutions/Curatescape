<?php head(array('bodyid'=>'items','bodyclass'=>'show','title' => item('Dublin Core', 'Title'))); ?>
<div id="content">
<article class="story item show">


	<div id="page-col-left" class="item">
		<section class="meta">
			<figure id="item-map">
			<?php mh_item_map();?>
			</figure>
			
			<figure id="item-audio">
			<?php mh_audio_files();?>
			</figure>
			
			<div id="subjects">  	
			<?php mh_subjects(); ?>
			</div>	
			
			<div id="tags">
			<?php mh_tags();?>	
			</div>
			
			<div id="relations">
			<?php mh_item_relations();?>			
			</div>
		</section>	
	</div>

	
	<div id="primary" class="show">
		<section id="text">
			<h1 class="item-title"><?php echo item('Dublin Core', 'Title'); ?></h1>
								
			<figure id="item-video" >
				<?php mh_video_files();?>
			</figure> 
				
			<div class="item-description">
				<?php echo item('Dublin Core', 'Description');?>
			</div>
			<?php echo link_to_item_edit();?>
		</section>
		
		<div class="item-related-links">
			<?php mh_related_links();?>
		</div>
	</div><!-- end primary -->


	<div id="page-col-right">
	<section class="meta">
		<figure id="item-photos">
		<?php mh_item_images();?>
		</figure>
				
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