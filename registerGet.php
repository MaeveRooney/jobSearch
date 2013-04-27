<?php
/**
 * check for GET request
 */
if (isset($_GET['tag']) && $_GET['tag'] != '') {
    // get tag
    $tag = $_GET['tag'];

    // include db handler
    require_once 'userFunctions.php';
    $db = new userFunctions();

    // check for tag type
    if ($tag == 'checkusername') {
        // Request type is check Login
        $username = $_GET['username'];

        // check for user
        $user = $db->checkUsernameAvailable($username);
        if ($user == false) {
        	// username not available
        	echo "Username not available";
        } else {
            echo "";
        }
    } elseif ($tag == 'checkemail') {
        // Request type is check Login
        $email = $_GET['email'];

        // check for user
        $user = $db->checkEmailAvailable($email);
        if ($user == false) {
        	// username not available
        	echo "Email not available";
        } else {
            echo "";
        }
    } else {
        echo "Invalid Request";
    }
} else {
    echo "Access Denied";
}
?>