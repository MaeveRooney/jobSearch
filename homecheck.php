<?php session_start();
	if ($_SESSION['userType'] == 'employer') {
        $url = "http://maeverooney.com/employerpage.php";
        header( "Location: $url" );
        exit();
	} elseif ($_SESSION['userType'] == 'jobSeeker') {
        $url = "http://maeverooney.com/jobseekerpage.php";
        header( "Location: $url" );
        exit();
	} else {
		$_SESSION['error']='You must log in to view this page';
        $url = "http://maeverooney.com/signin.php";
        header( "Location: $url" );
        exit();
	}
?>
