<?php head(array('title'=>'Browse by Tag')); ?>
<div id="content">
<section class="browse tags">			
<h1>Browse by Tag</h1>

	<div id="page-col-left">
		<aside>
		<!-- add left sidebar content here -->
		</aside>
	</div>


	<div id="primary" class="browse">
	<section id="tags">
    
	    
	    <nav class="secondary-nav" id="tag-browse"> 
		    <ul>
			<?php 
			if (function_exists('subject_browse_public_navigation_items')){
			echo nav(array('Browse All' => uri('items'), 'Browse by Tag' => uri('items/tags'), 'Browse by Subject' => uri('items/subject-browse')));
			}
			else{
			echo nav(array('Browse All' => uri('items'), 'Browse by Tag' => uri('items/tags')));
			} ?>
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