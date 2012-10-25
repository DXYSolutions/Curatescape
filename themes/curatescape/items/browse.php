<?php head(array('title'=>'Browse Stories')); ?>
<div id="content">
<section class="browse stories items">			

	<div id="page-col-left">
		<aside>
		<!-- add left sidebar content here -->
		</aside>
	</div>


	<div id="primary" class="browse">
	<section id="results">
	
		<h1><?php
		$tag = ($_GET['tags'] ? $_GET['tags'] : null);
		$query = ($_GET['search'] ? $_GET['search'] : null);
		$advanced = ($_GET['advanced'] ? true : false);
		
		if ( ($tag) && !($query) ) {
		echo 'Items tagged "'.$tag.'"';
		}
		elseif ($query) {
		echo (!($advanced) ? 'Search Results for "'.$query.'"':'Advanced Search Results');
		}	
		else{
		echo 'Browse Items';
		}	
		echo ': <span class="item-number">'.total_results().'</span>';
		// echo (($query) ? '<span id="refine-search">['.link_to_advanced_search($text = 'refine search').']</span>' : '' )
		?></h1>
			
		<nav class="secondary-nav" id="item-browse"> 
			<ul>
			<?php 
			if (function_exists('subject_browse_public_navigation_items')){
			echo nav(array(
			'Browse All' => uri('items'), 
			'Browse by Tag' => uri('items/tags'), 
			'Browse by Subject' => uri('items/subject-browse')
			));
			}
			else{
			echo nav(array(
			'Browse All' => uri('items'), 
			'Browse by Tag' => uri('items/tags')));
			} ?>
			</ul>
		</nav>
		
		<div class="pagination top"><?php echo pagination_links(); ?></div>
		
		<?php 
		while (loop_items()): 
			$description = item('Dublin Core', 'Description', array('snippet'=>250));
			$tags=tag_string(get_current_item(), uri('items/browse?tags='));
			$thumblink=link_to_item(item_square_thumbnail());
			$titlelink=link_to_item(item('Dublin Core', 'Title'), array('class'=>'permalink'));
			?>
			<article class="item-result">
				<?php if (item_has_thumbnail()): ?>
					<div class="item-thumb">
	    				<?php echo $thumblink; ?>						
	    			</div>
				<?php endif; ?>

				<h3><?php echo $titlelink; ?></h3>
				
				<?php if ($description): ?>
    				<div class="item-description">
    					<?php echo $description; ?>
    				</div>
				<?php endif; ?>

				<?php if (item_has_tags()): ?>
    				<div class="item-tags">
    				<p><span>Tags:</span> <?php echo $tags; ?></p>
    				</div>
				<?php endif; ?>
			</article> 
		<?php endwhile; ?>
		
		<div class="pagination bottom"><?php echo pagination_links(); ?></div>
				
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