<?php session_start();
	// check to see if user logged in. if not direct to signin page
	if ($_SESSION['name'] == '') {
		$_SESSION['error']='You must log in to view this page';
        $url = "http://maeverooney.com/signin.php";
        header( "Location: $url" );
        exit();
	}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Jobseeker Dashboard</title>
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
			<h1>Job Seeker Home Page</h1>
			<br/><br/>
		  <div class="row-fluid">
			<div class="span3">
			  <div class="well sidebar-nav">
				<ul class="nav nav-list">
				  <li class="nav-header">User Details</li>
				  <li>Name: <?php echo $_SESSION['name']; ?></li>
				  <li>Username: <?php echo $_SESSION['username']; ?></li>
				  <li>Email: <?php echo $_SESSION['email']; ?></li>
				</ul>
			  </div><!--/.well -->
			</div><!--/span-->

			<div class="span9">

				<h3>My Skills</h3>
					<form method="POST" id="jobSeekerSkillForm" action="registerpost.php" onsubmit="return ValidateRegister()">
						<input type="hidden" name="tag" value="addjobseekerskills"/>
						<div class="span3">
							<input onchange="this.form.submit()" type="checkbox" name="skills[]" value="1" <?php if (in_array("CSS",$_SESSION['skills'])) echo checked; ?>/> CSS<br/>
							<input onchange="this.form.submit()" type="checkbox" name="skills[]" value="2" <?php if (in_array("Java",$_SESSION['skills'])) echo checked; ?>/> Java<br/>
							<input onchange="this.form.submit()" type="checkbox" name="skills[]" value="3" <?php if (in_array("JavaScript",$_SESSION['skills'])) echo checked; ?>/> Javascript<br/>
							<input onchange="this.form.submit()" type="checkbox" name="skills[]" value="4" <?php if (in_array("C++",$_SESSION['skills'])) echo checked; ?>/> C++<br/>
							<input onchange="this.form.submit()" type="checkbox" name="skills[]" value="5" <?php if (in_array("C#",$_SESSION['skills'])) echo checked; ?>/> C#<br/>
						</div>
						<div class="span3">
							<input onchange="this.form.submit()" type="checkbox" name="skills[]" value="6" <?php if (in_array("Python",$_SESSION['skills'])) echo checked; ?>/> Python<br/>
							<input onchange="this.form.submit()" type="checkbox" name="skills[]" value="7" <?php if (in_array("PHP",$_SESSION['skills'])) echo checked; ?>/> PHP<br/>
							<input onchange="this.form.submit()" type="checkbox" name="skills[]" value="8" <?php if (in_array("MySQL",$_SESSION['skills'])) echo checked; ?>/> MySQL<br/>
							<input onchange="this.form.submit()" type="checkbox" name="skills[]" value="9" <?php if (in_array("SQLServer",$_SESSION['skills'])) echo checked; ?>/> SQLServer<br/>
							<input onchange="this.form.submit()" type="checkbox" name="skills[]" value="10" <?php if (in_array("Project Management",$_SESSION['skills'])) echo checked; ?>/> Project Management<br/>
						</div>
						<div class="span3">
							<input onchange="this.form.submit()" type="checkbox" name="skills[]" value="11" <?php if (in_array("Team Management",$_SESSION['skills'])) echo checked; ?>/> Team Management<br/>
							<input onchange="this.form.submit()" type="checkbox" name="skills[]" value="12" <?php if (in_array("Customer Service",$_SESSION['skills'])) echo checked; ?>/> Customer Service<br/>
							<input onchange="this.form.submit()" type="checkbox" name="skills[]" value="13" <?php if (in_array("Database Management",$_SESSION['skills'])) echo checked; ?>/> Database Management<br/>
							<input onchange="this.form.submit()" type="checkbox" name="skills[]" value="14" <?php if (in_array("Accounting",$_SESSION['skills'])) echo checked; ?>/> Accounting<br/>
							<input onchange="this.form.submit()" type="checkbox" name="skills[]" value="15" <?php if (in_array("Cryptography",$_SESSION['skills'])) echo checked; ?>/> Cryptography<br/>
						</div>
					</form>
					<br><br>
				</div><!--/span-->
				<div style="float:right" class="span9">
					<br>
					<h3>My Job Applications</h3>
				</div>
				<?php

					require_once 'userFunctions.php';
    				$db = new userFunctions();
    				$jobSeeker_id=$_SESSION['jobSeekerID'];
    				$applications = $db->getUserApplications($jobSeeker_id);
    				if (count($applications) ==0) {
    					echo "<p>No Applications</p>";
    				} else {
						foreach ($applications as $application){
							echo "<div style='float:right' class='span9 well'><div class='span6'>";
								echo "<h4>Name of Position: " . $application['name'] . "</h4>";
								echo "<p><strong>Company Name:</strong> " . $application['companyName'] . "</p>";
								echo "<p><strong>Location of Job:</strong></p><p> " . $application['address'] . "</p>";

								echo "<p><strong>Date Of Application:</strong> " . $application['salary'] . "</p>";
								$reviewed = ($application['reviewed'] == 0 ? 'No' : 'Yes');
								$responded = ($application['responded'] == 0 ? 'No' : 'Yes');
								echo "<p><strong>Reviewed by Employer:</strong> " . $reviewed . "</p>";
								echo "<p><strong>Response from Employer:</strong> " . $responded . "</p>";
								echo "<p><strong>Job Description:</strong></p><p> " . $application['jobDescription'] . "</p>";
								echo "<p><strong>My Cover Note:</strong></p><p> " . $application['coverNote'] . "</p>";
							echo "</div>";
							echo "<div class='span3'>";
								$skills = $application['skillArray'];
								if (count($skills) > 0){
									echo "<h5>Skills required for position:</h5>";
									foreach ($skills as $skill){
										echo $skill . "<br>";
									}
								}
							echo "<br>";
							echo "<h5>Contract Type:</h5><p> " . $application['contract'] . "</p>";
							echo "<h5>Salary:</h5><p> €" . $application['salary'] . " per year</p>";
							echo "<h5>Length Of Contract:</h5><p> " . $application['lengthOfContract'] . "</p>";
							echo "</div></div>";
						}
					}
    			?>

    	</div><!--/row-->

    </div><!--/.fluid-container-->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap-transition.js"></script>
    <script src="assets/js/bootstrap-alert.js"></script>
    <script src="assets/js/bootstrap-modal.js"></script>
    <script src="assets/js/bootstrap-dropdown.js"></script>
    <script src="assets/js/bootstrap-scrollspy.js"></script>
    <script src="assets/js/bootstrap-tab.js"></script>
    <script src="assets/js/bootstrap-tooltip.js"></script>
    <script src="assets/js/bootstrap-popover.js"></script>
    <script src="assets/js/bootstrap-button.js"></script>
    <script src="assets/js/bootstrap-collapse.js"></script>
    <script src="assets/js/bootstrap-carousel.js"></script>
    <script src="assets/js/bootstrap-typeahead.js"></script>

  </body>
</html>
