<?php
/**
 * check for POST request
 */
if (isset($_POST['tag']) && $_POST['tag'] != '') {
    // get tag
    $tag = $_POST['tag'];

    // include db handler
    require_once 'userFunctions.php';
    $db = new userFunctions();

    // check for tag type
    if ($tag == 'login') {
        // Request type is check Login
        $password = $_POST['password'];
        $username = $_POST['username'];

        // check for user
        $user = $db->getUserByUsernameAndPassword($username, $password);
        $admin = $db->getAdminByUsernameAndPassword($username, $password);
        if ($user) {
        	if(session_id() == '') {
        		// session isn't started
        		session_start();
			}
			$_SESSION['name']=$user["fullName"];
			$_SESSION['userType']='jobSeeker';
			$_SESSION['username']=$user["username"];
			$_SESSION['email']=$user["email"];
			$_SESSION['jobSeekerID']=$user["jobSeeker_id"];
			$_SESSION['skills'] = $db->getUserSkills((int) $user["jobSeeker_id"]);
        	$url = "http://maeverooney.com/jobseekerpage.php";
        } elseif ($admin) {
        	if(session_id() == '') {
        		// session isn't started
        		session_start();
			}
			$_SESSION['name']=$admin["name"];
			$_SESSION['userType']='employer';
			$_SESSION['username']=$admin["username"];
			$_SESSION['email']=$admin["email"];
			$_SESSION['employerID']=$admin["employer_id"];
        	$url = "http://maeverooney.com/employerpage.php";
        } else {
            // user not found
            //redirect back to login page with error message user not found
            if(session_id() == '') {
        		// session isn't started
        		session_start();
			}
			$_SESSION['error']='Login failed. Please try again';
            $url = "http://maeverooney.com/signin.php";
        }
        header( "Location: $url" );
        exit();
    } else {
        echo "Invalid Request";
    }
} else {
    echo "Access Denied";
}
?>