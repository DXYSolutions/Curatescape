<?php
// We don't need no stinking collections! 
head(array('title'=>'404','bodyid'=>'error','bodyclass'=>'collections browse error_404')); ?>
<div id="content">
<article class="error show">
<h2>404</h2>

	<div id="page-col-left">
		<aside>
		<!-- add left sidebar content here -->
		</aside>
	</div>


	<div id="primary" class="show">
		<section id="text">
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

</article>
</div> <!-- end content -->
<?php foot(); ?>