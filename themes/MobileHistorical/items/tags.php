<?php
if (mobile_device_detect()==true){
//begin mobile tags
?>
<?php head( array( 'title' => 'Browse Tags') );?>
<!-- Start of page content: #tags -->


<div data-role="content" id="browse">	
<?php echo mobile_simple_search();?>
			
			<?php $term=html_escape($_GET['tags']); ?>
			<?php $term2=html_escape($_GET['term']); ?>

	    
		<h2>Browse Tags </h2>

		<div data-role="footer">
			<div data-role="navbar">
				<ul>
				<?php //echo nav(array('All' => uri('items'), 'Tags' => uri('items/tags'))); ?>
				<li><a href="<?php echo uri('items')?>" data-transition="fade">All</a></li>
				<li><a href="<?php echo uri('items/tags')?>" data-transition="fade">Tags</a></li>
				</ul>
			</div><!-- /navbar -->
		</div><!-- /footer -->
		
		 <?php echo tag_cloud($tags,uri('items/browse')); ?>

<a href="#download-app" data-role="button" data-rel="dialog" data-transition="pop" id="download-app">Download the App</a>		
</div> <!-- end content-->

<?php echo common('m-footer-nav');?>

</div> <!-- end outer page from header -->	

<?php echo common('m-dialogues');?>

</body>
</html>


<?
//end mobile tags
	}
else{	
//begin non-mobile tags
?>
<?php head(array('title'=>'Browse by Tag')); ?>

<div id="content">
			
		    <div id="header">
			<div id="primary-nav">
    			<ul class="navigation">
    			    <?php echo mh_global_nav('desktop'); ?>
    			</ul>
    		</div>
    		<div id="search-wrap">
				    <?php echo simple_search(); ?>
    			</div>
    			<div style="clear:both;"></div>
   		</div>
	




<!-- -->
<div id="page-col-left">

<div id="lv-logo"><a href="<?php echo WEB_ROOT;?>/"><img src="<?php echo mh_med_logo_url(); ?>" border="0" alt="<?php echo settings('site_title');?>" title="<?php echo settings('site_title');?>" /></a></div>



</div>


	<div id="primary-browse" class="browse">
    
    <h1>Browse by Tag</h1>
    
    <ul class="navigation item-tags" id="secondary-nav">
			<?php 
			if (function_exists('subject_browse_public_navigation_items')){
			echo nav(array('Browse All' => uri('items'), 'Browse by Tag' => uri('items/tags'), 'Browse by Subject' => uri('items/subject-browse')));
			}
			else{
			echo nav(array('Browse All' => uri('items'), 'Browse by Tag' => uri('items/tags')));
			} ?>
    </ul>

    <?php echo tag_cloud($tags,uri('items/browse')); ?>

	</div><!-- end primary -->
	

<!-- -->



<?php foot(); ?>
<?php 
//end non-mobile tags
}?>