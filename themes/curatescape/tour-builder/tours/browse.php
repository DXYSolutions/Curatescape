<?php
head( array( 'title' => 'Tours', 'content_class' => 'horizontal-nav',
   'bodyclass' => 'tours primary browse-tours' ) );
?>
<div id="content">
<section class="browse tour">			
<h1>Browse Tours (<?php echo $total_records; ?> total)</h1>

	<div id="page-col-left">
		<aside>
		<!-- add left sidebar content here -->
		</aside>
	</div>


	<div id="primary" class="browse">
	<section id="results">
	
	

    <?php 
    if( has_tours() ){
    if( has_tours_for_loop() ){
		while( loop_tours() ){ 
		
			echo '<h3><a href="'.$this->url( array('action' => 'show', 'id' => tour( 'id' ) ) ).'">'.tour( 'title' ).'</a></h3>';
			
			$tourdesc = nls2p( tour( 'Description' ) );
			echo '<p>'.snippet($tourdesc,0,300).'</p>'; 

			}
		}
	}?>
    
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

</section>
</div> <!-- end content -->
<?php foot();?>