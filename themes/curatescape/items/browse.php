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
head(array('title'=>$title,'bodyid'=>'items','bodyclass'=>'browse')); 
?>
<figure id="browse-view">




	<div id="browse-map">
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



	
	<?php /*
	echo '<div id="header-imgs">';
	$index=1; 
	while (loop_items() && ($index<10)): 
		$description = item('Dublin Core', 'Description', array('snippet'=>250));
		$tags=tag_string(get_current_item(), uri('items/browse?tags='));
		$thumblink=link_to_item(item_square_thumbnail());
		$fullsizelink=link_to_item(item_fullsize());
		$titlelink=link_to_item(item('Dublin Core', 'Title'), array('class'=>'permalink'));
		
		echo $thumblink;
		$index++;
		endwhile;	
	echo '</div>';			
	*/?>
		


</figure>


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
		$index=1; // set index to one so we can use zero as an argument below
		$showImgNum= 0; // show this many images on the browse results page
		while (loop_items()): 
			$description = item('Dublin Core', 'Description', array('snippet'=>250));
			$tags=tag_string(get_current_item(), uri('items/browse?tags='));
			$thumblink=link_to_item(item_square_thumbnail());
			$titlelink=link_to_item(item('Dublin Core', 'Title'), array('class'=>'permalink'));
			?>
			<article class="item-result" id="item-result-<?php echo $index;?>">
			
				<h3><?php echo $titlelink; ?></h3>
				
				<?php if (item_has_thumbnail() && mh_reducepayload($index,$showImgNum)): ?>
					<div class="item-thumb">
	    				<?php echo $thumblink; ?>						
	    			</div>
				<?php endif; ?>

				
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