<?php session_start();
	$position_id;
	if ($_SESSION['name'] == '') {
		$_SESSION['error']='You must log in to apply for a job';
        $url = "http://maeverooney.com/signin.php";
        header( "Location: $url" );
        exit();
	}
	if ($_SESSION['jobSeekerID'] == '') {
		$_SESSION['error']='You must be an Job Seeker to apply for job';
        $url = "http://maeverooney.com/employerpage.php";
        header( "Location: $url" );
        exit();
	}
	if ($_GET['positionID'] == '' || $_GET['positionID'] == null || $_GET['positionID'] == 0) {
        $url = "http://maeverooney.com/employerpage.php";
        header( "Location: $url" );
        exit();
	} else {
		$position_id = $_GET['positionID'];
	}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Apply For Job</title>
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
			<h1>Apply For Job</h1>
			<br/><br/>
		  <div class="row-fluid">
			<div class="span3">
			  <div class="well sidebar-nav">
				<ul class="nav nav-list">
				  <li class="nav-header">Job Seeker Details</li>
				  <li>Name: <?php echo $_SESSION['name']; ?></li>
				  <li>Username: <?php echo $_SESSION['username']; ?></li>
				  <li>Email: <?php echo $_SESSION['email']; ?></li>
				</ul>
			  </div><!--/.well -->
			</div><!--/span-->

				<?php

					require_once 'userFunctions.php';
    				$db = new userFunctions();
    				// Get users applications from db and loop through them to display
    				$positions = $db->getPositionInformation($position_id); // returns array
    				if (count($positions) ==0) {
    					echo "<p>No Positions</p>";
    				} else {
						foreach ($positions as $position){
							$position_id = $position['positionID'];
							echo "<div style='float:right' class='well span9'><div class='span6'>";
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
						}
					}
    			?>
				<div style='float:right' class='span9'>

					<form method="POST" id="jobSeekerSkillForm" action="registerpost.php">
						<h5>Your Skills</h5>
						<input type="hidden" name="tag" value="addjobseekerskillsapply"/>

							<input type='hidden' name='positionID' value=<?php echo "'".$position_id."'"; ?>/>
						<!-- checks if user has skill and checks box if he/she does -->
						<!-- submits form and reloads page when user clicks checkbox -->
						<div style="width:30%" class="span3">
							<input onchange="this.form.submit()" type="checkbox" name="skills[]" value="1" <?php if (count($_SESSION['skills']) > 0 && in_array("CSS",$_SESSION['skills'])) echo checked; ?>/> CSS<br/>
							<input onchange="this.form.submit()" type="checkbox" name="skills[]" value="2" <?php if (count($_SESSION['skills']) > 0 && in_array("Java",$_SESSION['skills'])) echo checked; ?>/> Java<br/>
							<input onchange="this.form.submit()" type="checkbox" name="skills[]" value="3" <?php if (count($_SESSION['skills']) > 0 && in_array("JavaScript",$_SESSION['skills'])) echo checked; ?>/> Javascript<br/>
							<input onchange="this.form.submit()" type="checkbox" name="skills[]" value="4" <?php if (count($_SESSION['skills']) > 0 && in_array("C++",$_SESSION['skills'])) echo checked; ?>/> C++<br/>
							<input onchange="this.form.submit()" type="checkbox" name="skills[]" value="5" <?php if (count($_SESSION['skills']) > 0 && in_array("C#",$_SESSION['skills'])) echo checked; ?>/> C#<br/>
						</div>
						<div style="width:30%" class="span3">
							<input onchange="this.form.submit()" type="checkbox" name="skills[]" value="6" <?php if (count($_SESSION['skills']) > 0 && in_array("Python",$_SESSION['skills'])) echo checked; ?>/> Python<br/>
							<input onchange="this.form.submit()" type="checkbox" name="skills[]" value="7" <?php if (count($_SESSION['skills']) > 0 && in_array("PHP",$_SESSION['skills'])) echo checked; ?>/> PHP<br/>
							<input onchange="this.form.submit()" type="checkbox" name="skills[]" value="8" <?php if (count($_SESSION['skills']) > 0 && in_array("MySQL",$_SESSION['skills'])) echo checked; ?>/> MySQL<br/>
							<input onchange="this.form.submit()" type="checkbox" name="skills[]" value="9" <?php if (count($_SESSION['skills']) > 0 && in_array("SQLServer",$_SESSION['skills'])) echo checked; ?>/> SQLServer<br/>
							<input onchange="this.form.submit()" type="checkbox" name="skills[]" value="10" <?php if (count($_SESSION['skills']) > 0 && in_array("Project Management",$_SESSION['skills'])) echo checked; ?>/> Project Management<br/>
						</div>
						<div style="width:30%" class="span3">
							<input onchange="this.form.submit()" type="checkbox" name="skills[]" value="11" <?php if (count($_SESSION['skills']) > 0 && in_array("Team Management",$_SESSION['skills'])) echo checked; ?>/> Team Management<br/>
							<input onchange="this.form.submit()" type="checkbox" name="skills[]" value="12" <?php if (count($_SESSION['skills']) > 0 && in_array("Customer Service",$_SESSION['skills'])) echo checked; ?>/> Customer Service<br/>
							<input onchange="this.form.submit()" type="checkbox" name="skills[]" value="13" <?php if (count($_SESSION['skills']) > 0 && in_array("Database Management",$_SESSION['skills'])) echo checked; ?>/> Database Management<br/>
							<input onchange="this.form.submit()" type="checkbox" name="skills[]" value="14" <?php if (count($_SESSION['skills']) > 0 && in_array("Accounting",$_SESSION['skills'])) echo checked; ?>/> Accounting<br/>
							<input onchange="this.form.submit()" type="checkbox" name="skills[]" value="15" <?php if (count($_SESSION['skills']) > 0 && in_array("Cryptography",$_SESSION['skills'])) echo checked; ?>/> Cryptography<br/>
						</div>
					</form>
				</div>
				<div style='float:right' class='span9'>
					<div class='span6'>
							<h5>Cover Note (500 characters max)</h5><textarea rows="4" style="width: 600px" cols="50" maxlength="500" id="coverNote" name="coverNote" form="applyForm"></textarea>

					</div>
					<div style='float:right' class='span3'>
						<form id='applyForm' name='applyForm' onSubmit='return ValidateApplyForm()' method='POST' action='handleAd.php'>
							<input type='hidden' name='tag' value='applyforjob'>
							<input type='hidden' name='positionID' value=<?php echo "'".$position_id."'"; ?>/>
							<br><br>
							<font color="red"><h5 id="noteError"></h5></font>
							<button class="btn btn-large btn-primary" type="submit">Apply For Position</button>
						</form>
					</div>
    			</div>



    	</div><!--/row-->

    </div><!--/.fluid-container-->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/jobsearch.js"></script>

  </body>
</html>
