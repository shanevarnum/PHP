<?php

    include("functions.php");

    include("views/header.php");

		if (isset($_GET['page']) && $_GET['page'] == 'timeline') {
			
			include("views/timeline.php");
			
		} else if (isset($_GET['page']) && $_GET['page'] == 'search') {
			
			include("views/search.php");
			
		} else if (isset($_GET['page']) && $_GET['page'] == 'publicprofiles') {
			
			include("views/publicprofiles.php");
			
		} else if (isset($_GET['page']) && $_GET['page'] == 'Data') {
			
			include("views/data.php");
			
		} else if (isset($_GET['page']) && $_GET['page'] == 'Resources') {
			
			include("views/resources.php");
		
		} else {

			include("views/home.php");
			
		}
			
		include("views/footer.php");


?>