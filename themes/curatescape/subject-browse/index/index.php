<?php head(array('title'=>'Browse Items by Subject','bodyid'=>'subject-browse','bodyclass' => 'subject-browse browse')); ?>

<?php
  $db = get_db();
  $select = "SELECT DISTINCT et.text
             FROM " . $db->ElementTexts ." et
             JOIN ". $db->Elements . " e
             ON et.element_id = e.id
             WHERE e.name = 'Subject'
             AND e.element_set_id =
                 (SELECT id
                  FROM " . $db->ElementSets . " es
                  WHERE es.name = 'Dublin Core')
             ORDER BY et.text";
             $result = $db->fetchAll($select);
?>


<div id="content">
<section class="browse subjects">
<h2>Subjects: <?php echo count($result);?></h2>

	<div id="page-col-left">
		<aside>
		<!-- add left sidebar content here -->
		</aside>
	</div>


	<div id="primary" class="browse">
	<section id="subjects">
      
      	<nav class="secondary-nav" id="item-browse">
	  		<ul>
		  		<?php mh_item_browse_subnav(); ?>
			</ul>
      	</nav>
      	
        <nav class="tertiary-nav" id="subject-browse">
	        <ul class="pagination_list">
		        <!-- Alphabetical Helpers -->
		        <?php 
		        echo '<li class="pagination_range"><a href="#number">#0-9</a></li>';
		        foreach(range('A','Z') as $i) {
		        	echo "<li class='pagination_range'><a href='#$i'>$i</a></li>";
		        }?>                      
	        </ul>
        </nav>
        
			<?php
			$current_header = '';
			foreach ($result as $row) {
				$first_char = substr($row['text'],0,1);
				if (preg_match('/\W|\d/',$first_char )){
					$first_char = '#0-9';
				}
				if ($current_header !== $first_char){
					$current_header = $first_char;
				if ($current_header === '#0-9'){
					echo "<h3 class='sb-subject-heading' id='number'>$current_header</h3>";
				}
				else {
					echo "<h3 class='sb-subject-heading' id='$current_header'>$current_header</h3>";
				}
				}
				
				echo '<p class="sb-subject"><a href="' . uri('items/browse?term='.urlencode($row['text']).'&search=&advanced[0][element_id]=' . SUBJECT_BROWSE_DC_ID . '&advanced[0][type]=contains&advanced[0][terms]='. urlencode($row['text']) .'&submit_search=Search') . '">' . $row['text'] . '</a></p>';
			}?>
		
        	
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