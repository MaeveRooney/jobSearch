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
              <li><a href="postjob.php">Post Job</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

		<br/><br/>

		<div class="container-fluid">
			<h1>Job Listings</h1>
			<br/><br/>
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
							echo '<div style="float:right" class="span9">';
							echo '<h3>Job Applications for '.$position['positionName'].'</h3>';
							echo '</div>';
							$position_id = $position['positionID'];
							echo "<div style='float:right; border: 1px solid; padding:10px; margin:10px' class='span9'><div class='span6'>";
								echo "<h4>Name of Position: " . $position['positionName'] . "</h4>";
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
							echo "<h5>Length Of Contract:</h5><p> " . $position['lengthOfContract'] . "</p>";
							echo "</div></div>";


							$applications = $db->getApplicantsForPosition($position_id);
							echo "<div style='float:right' class='span8 well'>";
							if (count($applications) ==0) {
    								echo "<p>No applications for this position</p>";
    						} else {
								foreach ($applications as $application){
									echo "<div class='span5'>";
									echo "<p><strong>Name of Applicant:</strong></p><p> " . $application['jobSeekerName'] . "</p>";
									echo "<p><strong>Applicant contact Info:</strong></p><p>Landline: " . $application['jobSeekerLandline'] ."</p><p>Mobile: ". $application['jobSeekerMobile'] ."</p><p>Email: ". $application['jobSeekerEmail'] ."</p>";
									echo "<p><strong>Date Of Application:</strong> " . $application['date'] . "</p>";
									echo "<p><strong>Applicants Cover Note:</strong></p><p> " . $application['coverNote'] . "</p><br>";
									$reviewed = $application['reviewed'];
									$responded = $application['responded'];
									$rating = $application['rating'];
									$applicationID = $application['applicationID'];
									if ($responded == 0){
										echo '<form method="POST" action="registerpost.php">';
										echo '<input type="hidden" name="tag" value="responsedToApplication"/>';
										echo '<input type="hidden" name="position_id" value="'.$position_id.'"/>';
										echo '<input type="hidden" name="applicationID" value="'.$applicationID.'"/>';
										echo '<input onchange="this.form.submit()" type="checkbox" name="responded" value="1"/> Check this box if you have contacted applicant<br><br>';
										echo '</form>';
									} else {
										echo '<p><strong>Responded to Applicant:</strong> Yes</p>';
									}
									if ($rating == null){
										echo '<form method="POST" action="registerpost.php" onsubmit="return ValidateApplication()">';
										echo '<input type="hidden" name="tag" value="rateApplication"/>';
										echo '<input type="hidden" name="position_id" value="'.$position_id.'"/>';
										echo '<input type="hidden" name="applicationID" value="'.$applicationID.'"/>';
										echo 'Rate Application out of 100 <input onchange="this.form.submit()" maxlength="3" type="text" id="rating" name="rating"/>';
										echo '<font color="red"><p id="numberError"></p></font>';
										echo '</form>';

									} else {
										echo "<p><strong>Rating of Application is:</strong> " . $rating . "/100</p>";
									}
									echo "</div>";
									echo "<div class='span3' style='float:right'>";
									$applicantSkills = $db->getUserSkills($application['jobSeekerID']);
									echo "<h5>Applicants Skills:</h5>";
									if (count($applicantSkills) > 0){
										foreach ($applicantSkills as $skill){
											echo $skill . "<br>";
										}
									}
									echo "</div></div>";
								}
    						}


							echo "</div>";
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
