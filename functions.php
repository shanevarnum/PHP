<?php

    session_start();

		$link = mysqli_connect("localhost", "root", "Quanboy69", "ventsite");

			if (mysqli_connect_errno()) {
				
				print_r(mysqli_connect_error());
				exit();
				
			}

		if (isset($_GET['function']) && ($_GET['function'] == "logout")) {
			
			session_unset();
			
		}

			function time_since($since) {
			$chunks = array(
				array(60 * 60 * 24 * 365 , 'year'),
				array(60 * 60 * 24 * 30 , 'month'),
				array(60 * 60 * 24 * 7, 'week'),
				array(60 * 60 * 24 , 'day'),
				array(60 * 60 , 'hour'),
				array(60 , 'min'),
				array(1 , 'sec')
			);

			for ($i = 0, $j = count($chunks); $i < $j; $i++) {
				$seconds = $chunks[$i][0];
				$name = $chunks[$i][1];
				if (($count = floor($since / $seconds)) != 0) {
					break;
				}
			}

			$print = ($count == 1) ? '1 '.$name : "$count {$name}s";
			return $print;
		}

		function displayVent($type) {
			
			global $link;
			
			if ($type == 'public') {
				
				$whereClause = "";
					
			} else if ($type == 'isfollowing') {
				
				$query = "SELECT * FROM isfollowing WHERE follower = ". mysqli_real_escape_string($link, $_SESSION['id']);
				$result = mysqli_query($link, $query);
				
				$whereClause = "";
				
				while ($row = mysqli_fetch_assoc($result)) {
					
					if ($whereClause == "")
					{ 
							$whereClause = "WHERE";
					}else {
							$whereClause.= " OR";
					}
					$whereClause.= " userid = ".$row['isfollowing'];
					
					
				}
				
			} else if ($type == 'yourvents') {
				
			   $whereClause = "WHERE userid = ". mysqli_real_escape_string($link, isset($_SESSION['id']));
				
			} else if ($type == 'search') {
				
				echo '<p>Showing search results for "'.mysqli_real_escape_string($link, $_GET['q']).'":</p>';
				
			   $whereClause = "WHERE vent LIKE '%". mysqli_real_escape_string($link, $_GET['q'])."%'";
				
			} else if (is_numeric($type)) {
				
				$userQuery = "SELECT * FROM users WHERE id = ".mysqli_real_escape_string($link, $type)." LIMIT 1";
					$userQueryResult = mysqli_query($link, $userQuery);
					$user = mysqli_fetch_assoc($userQueryResult);
				
				echo "<h2>".mysqli_real_escape_string($link, $user['email'])."'s Vents</h2>";
				
				$whereClause = "WHERE userid = ". mysqli_real_escape_string($link, $type);
				
				
			}
			
			
			$query = "SELECT * FROM vents ".$whereClause." ORDER BY `datetime` DESC LIMIT 10";
			
			$result = mysqli_query($link, $query);
			
			if (!$result || mysqli_num_rows($result) == 0) {
				
				echo "There aren't any vents to display.";
				
			} else {
				
				while ($row = mysqli_fetch_assoc($result)) {
					
					$userQuery = "SELECT * FROM users WHERE id = ".mysqli_real_escape_string($link, $row['userid'])." LIMIT 1";
					$userQueryResult = mysqli_query($link, $userQuery);
					$user = mysqli_fetch_assoc($userQueryResult);
					
					echo "<div class='vent'><p><a href='?page=publicprofiles&userid=".$user['id']."'>".$user['email']."</a> <span class='time'>".time_since(time() - strtotime($row['datetime']))." ago</span>:</p>";
					
					echo "<p>".$row['vent']."</p>";
					
					echo "<p><a class='toggleFollow' data-userId='".$row['userid']."'>";
					
					$isFollowingQuery = "SELECT * FROM isFollowing WHERE follower = '". mysqli_real_escape_string($link, isset($_SESSION['id']))."' AND isFollowing = '". mysqli_real_escape_string($link, $row['userid'])."' LIMIT 1";
				$isFollowingQueryResult = mysqli_query($link, $isFollowingQuery);
				if (mysqli_num_rows($isFollowingQueryResult) > 0) {
					
					echo "Unfollow";
					
				} else {
					
					echo "Follow";
					
				}
					
					
					echo "</a></p></div>";
					
				}
				
			}
			
			
		}

		function displaySearch() {
			
		   echo '<form class="form-inline">
				 <div class="form-group">
					<input type="hidden" name="page" value="search">
					<input type="text" name="q" class="form-control" id="search" placeholder="Search">
				 </div>
				 <button type="submit" class="btn btn-primary">Search Vents</button>
				</form>';
			
			
		}

		function displayVentBox() {
			
			if(isset($_SESSION['id']) && $_SESSION['id'] > 0){
				
				echo '<div id="ventSuccess" class="alert alert-success">Your vent was posted!.</div>
				<div id="ventFail" class="alert alert-danger"></div>
					<div class="form">
						<div class="form-group">
							<textarea class="form-control" id="ventContent"></textarea>
						</div>
						<button type="submit" id="postVentButton" style="float:right"  class="btn btn-primary">Post Vent</button>
					</div>';
				
				
			}
			
			
		}

		function displayUsers() {
			
			global $link;
			
			$query = "SELECT * FROM users LIMIT 10";
			
			$result = mysqli_query($link, $query);
				
			while ($row = mysqli_fetch_assoc($result)) {
				
				echo "<p><a href='?page=publicprofiles&userid=".$row['id']."'>".$row['email']."</a></p>";
				
			}
			
			
			
		}

?>