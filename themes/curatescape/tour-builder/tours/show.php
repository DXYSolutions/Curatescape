<?php
$tourTitle = strip_formatting( tour( 'title' ) );
if( $tourTitle != '' && $tourTitle != '[Untitled]' ) {
   $tourTitle = ': &quot;' . $tourTitle . '&quot; ';
} else {
   $tourTitle = '';
}
$tourTitle = 'Tour' . $tourTitle;

head( array( 'title' => $tourTitle, 'content_class' => 'horizontal-nav',
   'bodyclass' => 'show' ) );
?>

<div id="content">
<article class="tour show">
			
	<div id="page-col-left">
		<section id="tour-items">
		<h3>Locations</h3>
		  <div>
	         <?php foreach( $tour->Items as $tourItem ): ?>
		         <li><a href="<?php echo uri('/') ?>items/show/<?php echo $tourItem->id; ?>">
		         <?php echo $this->itemMetadata( $tourItem, 'Dublin Core', 'Title' ); ?>
		         </a></li>
	         <?php endforeach; ?>
		  </div>
		</section>
	</div>


	<div id="primary" class="show">
    <section id="text">
		<h1><?php echo $tourTitle; ?></h1>
	
		   <div id="tour-description">
			    <h2>Description</h2>
			    <?php echo nls2p( tour( 'Description' ) ); ?>
		   </div>
			
		   <div id="tour-credits">
				<?php if(tour( 'Credits' )): ?>
			    <h2>Credits</h2>
			    <?php echo tour( 'Credits' ); ?>
			    <?php endif;?>  
		   </div>
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