<?php

class userFunctions {

    private $db;

    // constructor
    function __construct() {
        require_once 'DB_Connect.php';
        // connecting to database
        $this->db = new DB_Connect();
        $this->db->connect();
    }

    // destructor
    function __destruct() {

    }

	/**
     * check username available
     */
    public function checkUsernameAvailable($username) {
        $result = mysql_query("SELECT * FROM users WHERE username = '$username'") or die(mysql_error());
        // check for result
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            return false;
        } else {
            // username available
            return true;
        }
    }

    /**
     * check email available
     */
    public function checkEmailAvailable($email) {
        $result = mysql_query("SELECT * FROM users WHERE email = '$email'") or die(mysql_error());
        // check for result
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            return false;
        } else {
            // username available
            return true;
        }
    }

    /**
     * Get user by username and password
     */
    public function getUserByUsernameAndPassword($username, $password) {
        $result = mysql_query("SELECT * "
        				."FROM users "
        				."INNER JOIN jobSeekers "
        				."ON users.user_id=jobSeekers.userID "
        				."WHERE users.username = '$username'") or die(mysql_error());
        // check for result
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            $result = mysql_fetch_array($result);
            $salt = $result['salt'];
            $encrypted_password = $result['encrypted_password'];
            $hash = $this->checkhashSSHA($salt, $password);
            // check for password equality
            if ($encrypted_password == $hash) {
                // user authentication details are correct
                return $result;
            }
        } else {
            // user not found
            return false;
        }
    }

    /**
     * Get user by username and password
     */
    public function getAdminByUsernameAndPassword($username, $password) {
        $result = mysql_query("SELECT * "
        				."FROM users "
        				."INNER JOIN companies "
        				."ON users.user_id=companies.userID "
        				."WHERE users.username = '$username'") or die(mysql_error());
        // check for result
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            $result = mysql_fetch_array($result);
            $salt = $result['salt'];
            $encrypted_password = $result['encrypted_password'];
            $hash = $this->checkhashSSHA($salt, $password);
            // check for password equality
            if ($encrypted_password == $hash) {
                // user authentication details are correct
                return $result;
            }
        } else {
            // user not found
            return false;
        }
    }

    /**
     * add jobseeker to db transaction
     */
    public function addJobSeeker($username, $password, $email, $title, $fullname, $street1, $street2, $town, $county, $country, $landline, $mobile) {
		$hash = $this->hashSSHA($password);
        $encrypted_password = $hash["encrypted"]; // encrypted password
        $salt = $hash["salt"]; // salt
        try {
			// First of all, let's begin a transaction
			mysql_query("BEGIN");

			// A set of queries; if one fails, an exception should be thrown
			$firstQuery = "INSERT INTO users (username, email, encrypted_password, salt) values ('$username', '$email', '$encrypted_password', '$salt')" ;
			mysql_query($firstQuery);
			$userID = mysql_insert_id();
			$secondQuery = "INSERT INTO jobSeekers (userID, title, fullName, addressStreet1, addressStreet2, addressTown, addressCounty, addressCountry, landline, mobile) values('$userID','$title','$fullname','$street1', '$street2', '$town', '$county', '$country', '$landline', '$mobile')";
			mysql_query($secondQuery);

			// If we arrive here, it means that no exception was thrown
			// i.e. no query has failed, and we can commit the transaction
			mysql_query("COMMIT");
			return $this->getUserByUsernameAndPassword($username, $password);
		} catch (Exception $e) {
			// An exception has been thrown
			// We must rollback the transaction
			mysql_query("ROLLBACK");
		}
		return false;
    }

    /**
     * add employer to db transaction
     */
    public function addEmployer($username, $password, $email, $name, $street1, $street2, $town, $county, $country) {
		$hash = $this->hashSSHA($password);
        $encrypted_password = $hash["encrypted"]; // encrypted password
        $salt = $hash["salt"]; // salt
        try {
			// First of all, let's begin a transaction
			mysql_query("BEGIN");

			// A set of queries; if one fails, an exception should be thrown
			$firstQuery = "INSERT INTO users (username, email, encrypted_password, salt) values ('$username', '$email', '$encrypted_password', '$salt')" ;
			mysql_query($firstQuery);
			$userID = mysql_insert_id();
			$secondQuery = "INSERT INTO companies (userID, name) values('$userID','$name')";
			mysql_query($secondQuery);
			if ($street1 != "" || $street2 != "" || $town != "" || $county != "" || $country != "") {
				$companyID = mysql_insert_id();
				$thirdQuery = "INSERT INTO companyLocations (companyID, addressStreet1, addressStreet2, addressTown, addressCounty, addressCountry) values('$companyID','$street1', '$street2', '$town', '$county', '$country')";
				mysql_query($thirdQuery);
			}

			// If we arrive here, it means that no exception was thrown
			// i.e. no query has failed, and we can commit the transaction
			mysql_query("COMMIT");
			return $this->getAdminByUsernameAndPassword($username, $password);
		} catch (Exception $e) {
			// An exception has been thrown
			// We must rollback the transaction
			mysql_query("ROLLBACK");
		}
		return false;
    }


    /**
     * Get user skills
     */
    public function getUserSkills($jobSeeker_id) {
        $result = mysql_query("SELECT * "
        				."FROM jobSeekerSkills "
        				."INNER JOIN skills "
        				."ON skills.skill_id=jobSeekerSkills.skillID "
        				."WHERE jobSeekerSkills.jobSeekerID = '$jobSeeker_id'") or die(mysql_error());
        // check for result
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            $return_arr = array();
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
				array_push($return_arr,$row['name']);
			}
			return $return_arr;
        } else {
            return array();
        }
    }

    /**
     * add user skills
     */
    public function addUserSkills($jobSeeker_id, $skill_id) {
        $result = @mysql_query("INSERT INTO jobSeekerSkills (skillID, jobSeekerID) values ('$skill_id','$jobSeeker_id')");
    }

    /**
     * remove user skills
     */
    public function deleteUserSkills($jobSeeker_id) {
        $result = @mysql_query("DELETE FROM jobSeekerSkills WHERE jobSeekerID='$jobSeeker_id'");
    }

    /**
     * Encrypting password
     * @param password
     * returns salt and encrypted password
     */
    public function hashSSHA($password) {

        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }

    /**
     * Decrypting password
     * @param salt, password
     * returns hash string
     */
    public function checkhashSSHA($salt, $password) {

        $hash = base64_encode(sha1($password . $salt, true) . $salt);

        return $hash;
    }

}

?>