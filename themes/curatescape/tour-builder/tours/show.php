<?php
$tourTitle = strip_formatting( tour( 'title' ) );
if( $tourTitle != '' && $tourTitle != '[Untitled]' ) {
   $tourTitle = ': ' . $tourTitle . '';
} else {
   $tourTitle = '';
}
$tourTitle = 'Tour' . $tourTitle;

head( array( 'title' => $tourTitle, 'content_class' => 'horizontal-nav',
   'bodyclass' => 'show' ) );
?>

<div id="content">
<article class="tour show">

	<header id="tour-header">
	<h2 class="tour-title instapaper_title"><?php echo $tourTitle; ?></h2>
	<?php if(tour( 'Credits' )){
		echo '<span class="tour-meta">Posted by '.tour( 'Credits' ).'</span>';
	}?>
	</header>
			
	<div id="page-col-left">
	</div>


	<div id="primary" class="show">
	    <section id="text">
		   <div id="tour-description">
		    <h2>Description</h2>
		    <?php echo nls2p( tour( 'Description' ) ); ?>
		   </div>
		</section>
		   
		<section id="tour-items">
			<h2>Locations</h2>
	         <?php 
	         $i=1;
	         foreach( $tour->Items as $tourItem ): ?>
		         <article class="item-result">
			         <h3><?php echo $i.'.';?> <a href="<?php echo uri('/') ?>items/show/<?php echo $tourItem->id; ?>">
			         <?php echo $this->itemMetadata( $tourItem, 'Dublin Core', 'Title' ); ?>
			         </a></h3>
			         <div class="item-description"><?php echo snippet($this->itemMetadata( $tourItem, 'Dublin Core', 'Description' ),0,250); ?></div>
		         </article>
	         <?php 
	         $i++;
	         endforeach; ?>
		</section>
			   
	</div>


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
	
	
</article>
</div> <!-- end content -->
<?php foot(); ?>