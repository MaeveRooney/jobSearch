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
        if ($user != false) {
        	if ($user["isAdmin"] == 0) {
        		//then user is customer
        		//redirect to customer page
        	} else {
        		//redirect to admin page
        	}
        } else {
            // user not found
            //redirect back to login page with error message user not found
        }
    } else {
        echo "Invalid Request";
    }
} else {
    echo "Access Denied";
}
?>