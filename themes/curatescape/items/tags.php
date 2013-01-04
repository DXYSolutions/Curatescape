<?php head(array('title'=>'Browse by Tag','bodyid'=>'items','bodyclass'=>'browse tags')); ?>

<div id="content">
<section class="browse tags">			
<h2>Tags: <?php echo total_tags();?></h2>

	<div id="page-col-left">
		<aside>
		<!-- add left sidebar content here -->
		</aside>
	</div>


	<div id="primary" class="browse">
	<section id="tags">
    
	    
	    <nav class="secondary-nav" id="tag-browse"> 
		    <ul>
			<?php mh_item_browse_subnav(); ?>
		    </ul>
	    </nav>
	
	    <?php echo tag_cloud($tags,uri('items/browse')); ?>

	</section> 
	</div><!-- end primary -->

	<div id="page-col-right">
		<aside id="page-sidebar">
			<h3>Pages</h3>
			<nav>
			<?php echo mh_sidebar_nav();?>
			</nav>
				
			<div id="share-this">
			<?php echo mh_share_this();?>
			</div>
		</aside>
	</div>	

</section>	
</div> <!-- end content -->
<?php foot(); ?>