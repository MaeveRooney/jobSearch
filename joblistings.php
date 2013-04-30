<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>View Applications</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
    <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="assets/ico/favicon.png">
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="homecheck.php">Job Search</a>
          <div class="nav-collapse collapse">
          	<?php if ($_SESSION['name'] != '') {?>
				<p class="navbar-text pull-right">
				  Logged in as <?php echo $_SESSION['name']; ?>
				</p>
			<?php } else {?>
				<p class="navbar-text pull-right"><?php echo "You are not logged in";?></p>
			<?php } ?>
            <ul class="nav">
              <li><a href="homecheck.php">Home</a></li>
              <li class="active"><a href="joblistings.php">Job Listings</a></li>
              <li><a href="register.php">Register</a></li>
              <li><a href="logout.php">Log Out</a></li>
              <li><a href="signin.php">Log In</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

		<br/><br/>

		<div class="container-fluid">
			<h1>Job Listings</h1>

			<font color='blue'><p><strong>
			<?php
					//retrieve session data
					if(isset($_SESSION['flashMessage'])){
						echo $_SESSION['flashMessage'];
						unset($_SESSION['flashMessage']);
					}
				?>
			</strong></p></font>
			<br/><br/>
			<font color='red'><p><strong>
				<?php
					if(isset($_SESSION['error'])){
						echo $_SESSION['error'];
						unset($_SESSION['error']);
  					}
				?>
			</strong></p></font>
		  <div class="row-fluid">
			<div class="span3">
			  <div class="well sidebar-nav">
				<ul class="nav nav-list">
				  <li>Name: <?php echo $_SESSION['name']; ?></li>
				  <li>Username: <?php echo $_SESSION['username']; ?></li>
				  <li>Email: <?php echo $_SESSION['email']; ?></li>
				</ul>
			  </div><!--/.well -->
			</div><!--/span-->

				<div style="float:right" class="span9">

				</div>
				<?php

					require_once 'userFunctions.php';
    				$db = new userFunctions();
    				// Get users applications from db and loop through them to display
    				$positions = $db->getActivePositions(); // returns array
    				if (count($positions) ==0) {
    					echo "<p>No Positions</p>";
    				} else {
						foreach ($positions as $position){
							$position_id = $position['positionID'];
							echo "<div style='float:right' class='span9 well'><div class='span6'>";
								echo "<h4>Name of Position: " . $position['positionName'] . "</h4>";
								echo "<p><strong>Company:</strong></p><p> " . $position['companyName'] . "</p>";
								echo "<p><strong>Location of Job:</strong></p><p> " . $position['address'] . "</p>";
								echo "<p><strong>Date of Ad Activation:</strong></p><p> " . $position['dateActivated'] . "</p>";
								echo "<p><strong>Job Description:</strong></p><p> " . $position['jobDescription'] . "</p>";
								echo "</div>";
								echo "<div class='span3' style='float:right'>";
								$skills = $position['skillArray'];
								if (count($skills) > 0){
									echo "<h5>Skills required for position:</h5>";
									foreach ($skills as $skill){
										echo $skill . "<br>";
									}
								}
							echo "<br>";
							echo "<h5>Contract Type:</h5><p> " . $position['contract'] . "</p>";
							echo "<h5>Salary:</h5><p> €" . $position['salary'] . " per year</p>";
							echo "<h5>Length Of Contract:</h5><p> " . $position['lengthOfContract'] . "</p><br>";
							echo "<form method='GET' action='applyforjob.php'><input type='hidden' name='positionID' value='".$position_id."'/>";
							echo "<button class='btn btn-large btn-primary' type='submit'>Apply For Position</button></form>";
							echo "</div></div>";

						}
					}
    			?>



    	</div><!--/row-->

    </div><!--/.fluid-container-->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/jobsearch.js"></script>


  </body>
</html>
