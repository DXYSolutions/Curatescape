<?php 
$tag = ($_GET['tags'] ? $_GET['tags'] : null);
$term = ($_GET['term'] ? $_GET['term'] : null);
$query = ($_GET['search'] ? $_GET['search'] : null);
$advanced = ($_GET['advanced'] ? true : false);

if ( ($tag) && !($query) ) {
	$title = 'Stories tagged "'.$tag.'"';
}
elseif ( ($term) && !($query) ) {
	$title = 'Results for subject term "'.$term.'"';
}
elseif ($query) {
	$title = (!($advanced) ? 'Search Results for "'.$query.'"':'Advanced Search Results');
}	
else{
	$title = 'All Stories';
}	
head(array('title'=>$title)); 
?>
<div id="content">
<section class="browse stories items">			
	<h2><?php 
	$title .= ( (total_results()) ? ': <span class="item-number">'.total_results().'</span>' : '');
	echo $title; 
	?></h2>
		
		
	<div id="page-col-left">
		<aside>
		<!-- add left sidebar content here -->
		</aside>
	</div>


	<div id="primary" class="browse">
	<section id="results">
			
		<nav class="secondary-nav" id="item-browse"> 
			<ul>
			<?php echo mh_item_browse_subnav();?>
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
			<article class="item-result" id="item-result-<?php echo $index;?>">
			
				<h3><?php echo $titlelink; ?></h3>
				
				<?php if (item_has_thumbnail() && mh_reducepayload($index,3)): ?>
					<div class="item-thumb">
	    				<?php echo $thumblink; ?>						
	    			</div>
				<?php endif; ?>

				
				<?php if ($description): ?>
    				<div class="item-description">
    					<?php echo $description; ?>
    				</div>
				<?php endif; ?>

				<?php if (item_has_tags() && mh_reducepayload($index,3)): ?>
    				<div class="item-tags">
    				<p><span>Tags:</span> <?php echo $tags; ?></p>
    				</div>
				<?php endif; ?>
			</article> 
		<?php 
		$index++;
		endwhile; 
		?>
		
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