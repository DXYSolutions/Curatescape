<?php head(array('title'=>'403','bodyid'=>'403')); ?>
<div id="content">
<article class="error show">
<h1>403</h1>

	<div id="page-col-left">
		<aside>
		<!-- add left sidebar content here -->
		</aside>
	</div>


	<div id="primary" class="show">
		<section id="text">
		    <p>Sorry. Access Forbidden!</p>
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