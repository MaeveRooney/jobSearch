<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Register</title>
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
              <li class="active"><a href="register.php">Register</a></li>
              <li><a href="logout.php">Log Out</a></li>
              <li><a href="signin.php">Log In</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <br><br>

    <div class="container">

    	<h1>Register</h1>

    	<?php
			//retrieve session data
			if(isset($_SESSION['error'])){
				echo $_SESSION['error'];
  				unset($_SESSION['error']);
  			}
		?>

		<div class="row">

			<form method="POST" action="registerpost.php" onsubmit="return ValidateRegister()">
				<div class="span6">
					<input id="jobSeekerRadio" type="radio" name="userType" value="jobSeeker" onclick="ShowDiv()">
					<label for="jobSeeker">Job Seeker</label><br>
					<input id="employerRadio" type="radio" name="userType" value="employer" onclick="ShowDiv()">
					<label for="employer">Employer</label><br>
					<font color="red"><p id="userTypeError"></p></font>


					<p>Username (required)</p><input type="text" name="username" id="username" maxlength="15" placeholder="Username" onChange="CheckUsernameAvailable(this.value)"><br/>
					<font color="red"><p id="usernameError"></p></font>
					<p>Email Address (required)</p><input type="text" name="email" id="email" maxlength="50" placeholder="Email address" onChange="CheckEmail(this.value)"><br/>
					<font color="red"><p id="emailError"></p></font>
					<p>Password (required)</p><input type="password" id="password" maxlength="20" name="password" placeholder="Password"><br/>
					<p>Confirm Password (required)</p><input type="password" id="confirmPassword" maxlength="20" name="confirmPassword" placeholder="Confirm Password" onChange="CheckPasswords()"><br/>
					<font color="red"><p id="passwordError"></p></font>
				</div>
				<div class="span6" id="jobSeekerDiv" style="DISPLAY: none" >
					<p>Title</p><input type="text" name="title" id="title" maxlength="10" placeholder="Title"><br/>
					<p>Full Name (required)</p><input type="text" name="fullname" id="fullname" maxlength="50" placeholder="Full Name" onChange="CheckName(this.value)"><br/>
					<font color="red"><p id="fullnameError"></p></font>
					<p>Street Address</p><input type="text" name="street1" id="street1" maxlength="50" placeholder="Street Address"><br/>
					<input type="text" name="street2" id="street2" maxlength="50" placeholder="Street Address"><br/>
					<p>Town</p><input type="text" name="town" id="town" maxlength="50" placeholder="Town"><br/>
					<p>County</p><input type="text" name="county" id="county" maxlength="50" placeholder="County"><br/>
					<p>Country</p><input type="text" name="country" id="country" maxlength="50" placeholder="Country"><br/>
					<p>Landline Phone</p><input type="text" name="landline" id="landline" maxlength="20" placeholder="Landline Phone"><br/>
					<p>Mobile Phone</p><input type="text" name="mobile" id="mobile" maxlength="20" placeholder="Mobile Phone"><br/>
				</div>
				<div class="span6" id="employerDiv" style="DISPLAY: none" >
					<p>Name of Company (required)</p><input type="text" name="name" id="name" maxlength="50" placeholder="Name of Company" onChange="CheckName(this.value)"><br/>
					<font color="red"><p id="nameError"></p></font>
					<p>Street Address</p><input type="text" name="street1" id="street1" maxlength="50" placeholder="Street Address"><br/>
					<input type="text" name="street2" id="street2" maxlength="50" placeholder="Street Address"><br/>
					<p>Town</p><input type="text" name="town" id="town" maxlength="50" placeholder="Town"><br/>
					<p>County</p><input type="text" name="county" id="county" maxlength="50" placeholder="County"><br/>
					<p>Country</p><input type="text" name="country" id="country" maxlength="50" placeholder="Country"><br/>
				</div>

				<div class="span12">
					<button class="btn btn-large btn-primary" type="submit">Register</button>
				</div>
			  </form>

		</div> <!-- row-->

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	<script src="assets/js/jobsearch.js"></script>


  </body>
</html>
