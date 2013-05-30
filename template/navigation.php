	<div id="navigation">

		<h1>Navigation</h1>
		<ul>
			<li><a href="home.php">News</a></li>
			<li><a href="history.php">A Little History</a></li>
			<li><a href="current.php">Current Notes</a></li>
			<li><a href="auditions.php">Auditions</a></li>
			<li><a href="recordings.php">Recordings</a></li>
			<li><a href="repertoire.php">Repertoire</a></li>
			<li><a href="alumni.php">Alumni</a></li>
			<li><a href="http://www.facebook.com/pages/The-Class-Notes/13607140518?">Facebook</a></li>
			<!-- <li><a href="onlinetix.php" style="color: #FFFFFF">Buy Tickets Online</a></li> -->
			<li><a href="contact.php">Contact Us</a>
		</ul>

	</div>
	
	 
	<?php 
		if (ABSPATH != 'ABSPATH') {
			include(ABSPATH . "../template/events.php");
		} else {
			include("./template/events.php");
		}
	?>
