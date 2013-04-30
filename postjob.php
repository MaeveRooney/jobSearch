<?php
	session_start();
	require_once 'userFunctions.php';
	$db = new userFunctions();
	$locations = $db->getCompanyLocations($_SESSION['employerID']); // returns array
	if ($_SESSION['employerID'] == '') {
		$_SESSION['error']='You must be an Employer to view this page';
        $url = "http://maeverooney.com/jobseekerpage.php";
        header( "Location: $url" );
        exit();
	}
	if (count($locations) == 0) {
		$_SESSION['error']='You must have a company address to post a job';
        $url = "http://maeverooney.com/employerpage.php";
        header( "Location: $url" );
        exit();
	}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Create Job To Advertise</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">

    </style>
    <link href="../assets/css/bootstrap-responsive.css" rel="stylesheet">

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
              <li><a href="joblistings.php">Job Listings</a></li>
              <li><a href="register.php">Register</a></li>
              <li><a href="logout.php">Log Out</a></li>
              <li><a href="signin.php">Log In</a></li>
              <li class="active"><a href="postjob.php">Post Job</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <br><br>

    <div class="container-fluid">
		<br>
    	<h1>Post Advertisement for Job Position</h1>

    	<?php
			//retrieve session data
			if(isset($_SESSION['error'])){
				echo $_SESSION['error'];
  				unset($_SESSION['error']);
  			}

		?>

		<br><br>
		<div class="row">

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

			<form method="POST" action="handleAd.php" id="jobForm"">
					<input type="hidden" name="tag" value="postAd"/>
					<div class="span9">
						<h5>Choose skills required for position</h5>
					</div>
						<div class="span3">
							<input type="checkbox" name="skills[]" value="1"/> CSS<br/>
							<input type="checkbox" name="skills[]" value="2" /> Java<br/>
							<input type="checkbox" name="skills[]" value="3" /> Javascript<br/>
							<input type="checkbox" name="skills[]" value="4" /> C++<br/>
							<input type="checkbox" name="skills[]" value="5" /> C#<br/>
						</div>
						<div class="span3">
							<input type="checkbox" name="skills[]" value="6" /> Python<br/>
							<input type="checkbox" name="skills[]" value="7" /> PHP<br/>
							<input type="checkbox" name="skills[]" value="8" /> MySQL<br/>
							<input type="checkbox" name="skills[]" value="9" /> SQLServer<br/>
							<input type="checkbox" name="skills[]" value="10" /> Project Management<br/>
						</div>
						<div class="span3">
							<input type="checkbox" name="skills[]" value="11"/> Team Management<br/>
							<input type="checkbox" name="skills[]" value="12"/> Customer Service<br/>
							<input type="checkbox" name="skills[]" value="13"/> Database Management<br/>
							<input type="checkbox" name="skills[]" value="14"/> Accounting<br/>
							<input type="checkbox" name="skills[]" value="15"/> Cryptography<br/>
						</div>
						<br><br>
					<div class="span5">
					<h5>Name of Position (required)</h5><input type="text" name="name" id="name" maxlength="50" placeholder="Name of Position"/><br>
					<font color="red"><h5 id="nameError"></h5></font>
					<br>
					<h5>Choose Address of Job</h5>
					<?php
						echo "<select name='location_id'>";
						foreach ($locations as $location){
							$location_id = $location['location_id'];
							$address = $location['address'];
							echo "<option value='".$location_id."'>".$address."</option>";
						}
						echo "</select>";
					?>
					<br><br>
					<h5>Select Contract Type</h5>
					<?php
						$contracts = $db->getContractTypes(); // returns array
						echo "<select name='contract_id'>";
						foreach ($contracts as $contract){
							$contract_id = $contract['contract_id'];
							$name = $contract['name'];
							echo "<option value='".$contract_id."'>".$name."</option>";
						}
						echo "</select>";
					?>
					<br><br>
					<h5>Length of Contract (eg '1 year')</h5><input type="text" name="length" id="length" maxlength="20" placeholder="Length of Contract"/><br>
					<font color="red"><h5 id="lengthError"></h5></font>
					<br>
					<h5>Salary (€ per year)</h5><input maxlength="8" type="text" id="salary" name="salary"/>
					<font color="red"><h5 id="salaryError"></h5></font>
					<br><br>
					<label for="male">Post Ad now</label>
					<input type="radio" name="postnow" value="yes" checked/><br><br>
				 	<label for="female">Post Ad later from home page</label>
					<input type="radio" name="postnow" value="no"/>
					<br><br>
					<button class="btn btn-large btn-primary" type="submit">Post Job</button>
					</form>
					<br><br>
				</div>
				<div class="span4">
					<h5>Job Description (required)</h5><textarea rows="4" cols="50" maxlength="400" id="jobDescription" name="jobDescription" form="jobForm"></textarea>
					<font color="red"><h5 id="descriptionError"></h5></font>
				</div>



		</div> <!-- row-->

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	<script src="assets/js/jobsearch.js"></script>

  </body>
</html>
