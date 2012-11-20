<footer>
	<nav id="footer-nav">
    	<ul class="navigation">
	    	<?php echo mh_global_nav(); ?>
	    </ul>
    </nav>	
    
	<p>
		Powered by <a href="http://omeka.org/">Omeka</a> + <a href="http://curatescape.org">Curatescape</a>
		<br>
		&copy; <?php echo date('Y').' '.settings('author');?> 
		<br>
		<span id="app-store-links"><?php mh_appstore_footer(); ?></span>
	</p>

	
</footer>

</div><!--end wrap-->

</body>

</html>