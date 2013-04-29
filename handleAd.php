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
    if ($tag == 'deactivate') {
        if(session_id() == '') {
			// session isn't started
			session_start();
		}
		$url = "http://maeverooney.com/employerpage.php";
		$position_id=(int) $_POST['position_id'];
		$db->deactivateAd($position_id);
		$_SESSION['flashMessage']="Ad has been successfully deactivated";
		header( "Location: $url" );
        exit();
    } elseif ($tag == 'activateAd') {
        if(session_id() == '') {
			// session isn't started
			session_start();
		}
		$_SESSION['flashMessage']="Ad has been successfully activated";
		$url = "http://maeverooney.com/employerpage.php";
		$position_id=(int) $_POST['position_id'];
		$db->activateAd($position_id);
		header( "Location: $url" );
        exit();
    } elseif ($tag == 'postAd') {
        if(session_id() == '') {
			// session isn't started
			session_start();
		}
		$_SESSION['flashMessage']="Job position has been successfully created";
		$url = "http://maeverooney.com/employerpage.php";
		$location_id=(int) $_POST['location_id'];
		$contract_id=(int) $_POST['contract_id'];
		$length = $_POST['length'];
		$salary = $_POST['salary'];
		$description = $_POST['jobDescription'];
		$postnow= $_POST['postnow'];
		$skillArray = $_POST['skills'];
		$name = $_POST['name'];
		$db->createJobPosition($location_id, $contract_id, $salary, $length, $description, $postnow, $skillArray, $name);


		header( "Location: $url" );
        exit();
    } else {
        echo "Invalid Request";
    }
}else {
    echo "Access Denied";
}
?>