<?php session_start();
	if ($_SESSION['name'] == '') {
		$_SESSION['error']='You must log in to view this page';
        $url = "http://maeverooney.com/signin.php";
        header( "Location: $url" );
        exit();
	}
	if ($_SESSION['employerID'] == '') {
		$_SESSION['error']='You must be an Employer to view this page';
        $url = "http://maeverooney.com/jobseekerpage.php";
        header( "Location: $url" );
        exit();
	}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Company Dashboard</title>
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
              <li class="active"><a href="homecheck.php">Home</a></li>
              <li><a href="joblistings.php">Job Listings</a></li>
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
			<h1>Employer Home Page</h1>
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
			<br/><br/>
		  <div class="row-fluid">
			<div class="span3">
			  <div class="well sidebar-nav">
				<ul class="nav nav-list">
				  <li class="nav-header">Company Details</li>
				  <li>Company Name: <?php echo $_SESSION['name']; ?></li>
				  <li>Username: <?php echo $_SESSION['username']; ?></li>
				  <li>Email: <?php echo $_SESSION['email']; ?></li>
				</ul>
			  </div><!--/.well -->
			</div><!--/span-->

				<div style="float:right" class="span9">
					<h3>Active Ads</h3>
						<p>Select a job position to view applications or deactivate ad</p>
				<?php

					require_once 'userFunctions.php';
    				$db = new userFunctions();
    				$employer_id=$_SESSION['employerID'];
    				// Get users applications from db and loop through them to display
    				$positions = $db->getActiveEmployerPositions($employer_id); // returns array
    				if (count($positions) == 0){
						echo "<h4>No active positions</h4>";
    				}else {
						echo '<form method="GET" id="jobSeekerSkillForm" action="viewApplications.php">';
						echo "<select name='positionID' onchange='this.form.submit()' style='width: 600px'>";
						echo "<option value='0'></option>";
						foreach ($positions as $position){
							$position_id = $position['positionID'];
							$positionName = $position['positionName'];
							$positionAddress = $position['address'];
							echo "<option value='" . $position_id ."'>".$positionName." | ".$positionAddress."</option>";
						}
						echo "</select></form>";

					}

    			?>

    			<h3>Job Positions not being advertised</h3>
						<p>Select a job position to reactivate ad</p>
				<?php

					require_once 'userFunctions.php';
    				$db = new userFunctions();
    				$employer_id=$_SESSION['employerID'];
    				// Get users applications from db and loop through them to display
    				$positions = $db->getInactiveEmployerPositions($employer_id); // returns array
    				if (count($positions) == 0){
						echo "<h4>No active positions</h4>";
    				}else {
						echo '<form method="GET" id="jobSeekerSkillForm" action="advertiseposition.php">';
						echo "<select name='positionID' onchange='this.form.submit()' style='width: 600px'>";
						echo "<option value='0'></option>";
						foreach ($positions as $position){
							$position_id = $position['positionID'];
							$positionName = $position['positionName'];
							$positionAddress = $position['address'];
							echo "<option value='" . $position_id ."'>".$positionName." | ".$positionAddress."</option>";
						}
						echo "</select></form>";
					}

    			?>
				</div>

				<div style="float:right" class="span9">
						<a class="btn btn-large btn-primary" href="postjob.php">Advertise New Position</a>


				    	<h3>Company Locations</h3>
				<?php

					require_once 'userFunctions.php';
    				$db = new userFunctions();
    				$employer_id=$_SESSION['employerID'];
    				// Get users applications from db and loop through them to display
    				$locations = $db->getCompanyLocations($employer_id); // returns array
    				if (count($locations) == 0){
						echo "<h4>No company locations</h4>";
    				}else {
						echo '<form method="GET" id="jobSeekerSkillForm">';
						echo "<ul>";
						foreach ($locations as $location){
							$address = $location['address'];
							echo "<li>".$address."</li>";
						}
						echo "</ul>";
					}

    			?>

    				<a class="btn btn-large btn-primary" href="addlocation.php">Add new location</a>
    				<br><br>

    			</div>


    	</div><!--/row-->

    </div><!--/.fluid-container-->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/jobsearch.js"></script>

  </body>
</html>
