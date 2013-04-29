<?php
/**
 * check for POST request
 */
if (isset($_POST['userType']) && $_POST['userType'] != '') {
    // get tag
    $tag = $_POST['userType'];
    $password = $_POST['password'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $street1 = $_POST['street1'];
    $street2 = $_POST['street2'];
    $town = $_POST['town'];
    $county = $_POST['county'];
    $country = $_POST['country'];

    // include db handler
    require_once 'userFunctions.php';
    $db = new userFunctions();

    // check for tag type
    if ($tag == 'jobSeeker') {
        // Request type is jobSeeker
		$title = $_POST['title'];
		$fullname = $_POST['fullname'];
		$landline = $_POST['landline'];
		$mobile = $_POST['mobile'];

		$user = $db->addJobSeeker($username, $password, $email, $title, $fullname, $street1, $street2, $town, $county, $country, $landline, $mobile);
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
		} else {
            //redirect back to register page with error message user not found
            if(session_id() == '') {
        		// session isn't started
        		session_start();
			}
			$_SESSION['error']='Registration failed. Please try again';
            $url = "http://maeverooney.com/register.php";
        }
		header( "Location: $url" );
        exit();
    } elseif ($tag == 'employer') {
        // Request type is employer

		$name = $_POST['name'];

		$user = $db->addEmployer($username, $password, $email, $name, $street1, $street2, $town, $county, $country);
		if ($user) {
			if(session_id() == '') {
        		// session isn't started
        		session_start();
			}
			$_SESSION['name']=$user["companyName"];
			$_SESSION['userType']='employer';
			$_SESSION['username']=$user["username"];
			$_SESSION['email']=$user["email"];
			$_SESSION['employerID']=$user["company_id"];
        	$url = "http://maeverooney.com/employerpage.php";
		} else {
            //redirect back to register page with error message user not found
            if(session_id() == '') {
        		// session isn't started
        		session_start();
			}
			$_SESSION['error']='Registration failed. Please try again';
            $url = "http://maeverooney.com/register.php";
        }
		header( "Location: $url" );
        exit();
    }else {
        echo "Invalid Request";
    }
} elseif (isset($_POST['tag']) && $_POST['tag'] != '') {
    // get tag
    $tag = $_POST['tag'];

    // include db handler
    require_once 'userFunctions.php';
    $db = new userFunctions();

    // check for tag type
    if ($tag == 'addjobseekerskills') {
        if(session_id() == '') {
			// session isn't started
			session_start();
		}
		$url = "http://maeverooney.com/jobseekerpage.php";
		$jobSeeker_id=(int) $_SESSION['jobSeekerID'];
		$db->deleteUserSkills($jobSeeker_id);
		$skillArray = $_POST['skills'];
		$N = count($skillArray);
		for($i=0; $i < $N; $i++){
			$db->addUserSkills($jobSeeker_id, (int) $skillArray[$i]);
		}
		$_SESSION['skills'] = $db->getUserSkills($jobSeeker_id);
		header( "Location: $url" );
        exit();
    } elseif ($tag == 'rateApplication') {
		$application_id = $_POST['applicationID'];
		$rating = (int) $_POST['rating'];
		$position_id = $_POST['position_id'];
		$url = 'http://maeverooney.com/viewApplications.php?positionID='.$position_id;
		if (is_numeric($rating)){
			$db->rateApplication($application_id, $rating);
		}
		header( "Location: $url" );
        exit();
    } elseif ($tag == 'responsedToApplication') {
		$application_id = $_POST['applicationID'];
		$position_id = $_POST['position_id'];
		$url = 'http://maeverooney.com/viewApplications.php?positionID='.$position_id;
		$db->respondToApplication($application_id);
		header( "Location: $url" );
        exit();
    } elseif ($tag == 'addlocation') {
    	if(session_id() == '') {
			// session isn't started
			session_start();
		}
		$street1 = $_POST['street1'];
		$street2 = $_POST['street2'];
		$town = $_POST['town'];
		$county = $_POST['county'];
		$country = $_POST['country'];
		$employer_id = $_SESSION['employerID'];
		$url = 'http://maeverooney.com/employerpage.php';
		$_SESSION['flashMessage'] = "New location successfully added";
		$db->addLocation($employer_id, $street1, $street2, $town, $county, $country);
		header( "Location: $url" );
        exit();
    }else {
        echo "Invalid Request";
    }
}else {
    echo "Access Denied";
}
?>