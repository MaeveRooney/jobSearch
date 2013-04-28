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
     * Get user applications
     */
    public function getUserApplications($jobSeeker_id) {
        $result = mysql_query("SELECT * "
        				."FROM jobApplications "
        				."INNER JOIN jobPositions "
        				."ON jobApplications.positionID=jobPositions.position_id "
        				."WHERE jobApplications.jobSeekerID = '$jobSeeker_id'") or die(mysql_error());
        // check for result
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            $return_arr = array();
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
				$position_id = $row['positionID'];
				$location_id = $row['companyLocationID'];
				$row_array['companyName'] = $this->getCompanyName($location_id);
				$row_array['address'] = $this->getCompanyLocationAddress($location_id);
				$row_array['positionID'] = $position_id;
				$row_array['name'] = $row['name'];
				$date = date("d-m-Y", strtotime($row['date']));
				$row_array['date'] = $date;
				$row_array['coverNote'] = $row['coverNote'];
				$contractID = $row['contractTypeID'];
				$result2 = mysql_query("SELECT name FROM contractTypes WHERE contract_id = '$contractID'") or die(mysql_error());
				// check for result
				$no_of_rows = mysql_num_rows($result2);
				if ($no_of_rows > 0) {
					$result2 = mysql_fetch_array($result2);
					$row_array['contract'] = $result2['name'];
				}
				$row_array['skillArray'] = $this->getPositionSkills($position_id);
				$row_array['lengthOfContract'] = $row['lengthOfContract'];
				$row_array['jobDescription'] = $row['jobDescription'];
				$row_array['salary'] = $row['salary'];
				$row_array['reviewed'] = $row['reviewed'];
				$row_array['responded'] = $row['responded'];
				array_push($return_arr,$row_array);
			}
			return $return_arr;
        } else {
            return array();
        }
    }

    /**
     * Get position skills
     */
    public function getPositionSkills($position_id) {
        $result = mysql_query("SELECT * "
        				."FROM positionSkills "
        				."INNER JOIN skills "
        				."ON skills.skill_id=positionSkills.skillID "
        				."WHERE positionSkills.positionID = '$position_id'") or die(mysql_error());
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
     * Get company name
     */
    public function getCompanyName($location_id) {
        $result = mysql_query("SELECT * "
        				."FROM companies "
        				."INNER JOIN companyLocations "
        				."ON companies.company_id=companyLocations.companyID "
        				."WHERE companyLocations.location_id = '$location_id'") or die(mysql_error());
        // check for result
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            $result = mysql_fetch_array($result);
			return $result['name'];
        }
    }

    /**
     * Get company address
     */
    public function getCompanyLocationAddress($location_id) {
        $result = mysql_query("SELECT * FROM companyLocations WHERE location_id = '$location_id'") or die(mysql_error());
        // check for result
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            $result = mysql_fetch_array($result);
            $returnString;
            if (strlen($result['addressStreet1'])>0){
            	$returnString .= $result['addressStreet1'] .", ";
            }
            if (strlen($result['addressStreet2'])>0){
            	$returnString .= $result['addressStreet2'] .", ";
            }
            if (strlen($result['addressTown'])>0){
            	$returnString .= $result['addressTown'] .", ";
            }
            if (strlen($result['addressCounty'])>0){
            	$returnString .= $result['addressCounty'] .", ";
            }
            if (strlen($result['addressCountry'])>0){
            	$returnString .= $result['addressCountry'] .". ";
            }
			return $returnString;
        }
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