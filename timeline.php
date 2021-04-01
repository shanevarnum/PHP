<div class="container mainContainer">

	<div class="row">
	  <div class="col-md-8">
			
			<h2><strong>Recent vent sessions</strong></h2>
			
			<?php displayVent('isFollowing'); ?>
		  
	  </div>	
		<div class="col-md-4">
			
			
		  
		  <br><br><br><br>
		  
		  <?php displayVentBox(); ?>
			
		</div>
		<div class="col-md-4">
			  <h2><strong>Related news</strong></h2>
		  <?php
			$rss = new DOMDocument();
			$rss->load('https://rss.medicalnewstoday.com/depression.xml');
			$feed = array();
			foreach ($rss->getElementsByTagName('item') as $node) {
				$item = array ( 
					'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
					'desc' => $node->getElementsByTagName('description')->item(0)->nodeValue,
					'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
					'date' => $node->getElementsByTagName('pubDate')->item(0)->nodeValue,
					);
				array_push($feed, $item);
			}
			$limit = 5;
			for($x=0;$x<$limit;$x++) {
				$title = str_replace(' & ', ' &amp; ', $feed[$x]['title']);
				$link = $feed[$x]['link'];
				$description = $feed[$x]['desc'];
				$date = date('l F d, Y', strtotime($feed[$x]['date']));
				echo '<p><strong><a href="'.$link.'" title="'.$title.'">'.$title.'</a></strong><br />';
				echo '<small><em>Posted on '.$date.'</em></small></p>';
				echo '<p>'.$description.'</p>';
			}
		  ?>
				
				
		</div>	
	</div>
    
</div>