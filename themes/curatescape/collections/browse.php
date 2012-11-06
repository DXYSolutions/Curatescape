<?php
// We don't need no stinking collections! 
head(array('title'=>'404')); ?>
<div id="content">
<section class="error show">			

	<div id="page-col-left">
		<aside>
		<!-- add left sidebar content here -->
		</aside>
	</div>

	<div id="primary" class="show">
		<section id="text">	
		    <h1>404</h1>
		    <p>Sorry. The page you are looking for does not exist!</p>
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
<?php foot(); ?>