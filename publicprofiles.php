<div class="container mainContainer">

  <div class="row">
  <div class="col-md-8">
      
      <?php if (isset($_GET['userid'])) { ?>
      
      <?php displayVent($_GET['userid']); ?>
      
      <?php } else { ?> 
        
		<?php displaySearch(); ?>
			<hr>
		
			<h2>Active Users</h2>
        
        <?php displayUsers(); ?>
      
      <?php } ?>
      
	  
  </div>
  
  </div>
    
</div>