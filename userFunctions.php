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
    	$username = mysql_real_escape_string($username);
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
    	$email = mysql_real_escape_string($email);
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
    	$username = mysql_real_escape_string($username);
    	$password = mysql_real_escape_string($password);
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
    	$username = mysql_real_escape_string($username);
    	$password = mysql_real_escape_string($password);
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
    	$password = mysql_real_escape_string($password);
    	$username = mysql_real_escape_string($username);
    	$email = mysql_real_escape_string($email);
    	$title = mysql_real_escape_string($title);
    	$fullname = mysql_real_escape_string($fullname);
    	$street1 = mysql_real_escape_string($street1);
    	$street2 = mysql_real_escape_string($street2);
    	$town = mysql_real_escape_string($town);
    	$county = mysql_real_escape_string($county);
    	$country = mysql_real_escape_string($country);
    	$landline = mysql_real_escape_string($landline);
    	$mobile = mysql_real_escape_string($mobile);
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
    	$password = mysql_real_escape_string($password);
    	$username = mysql_real_escape_string($username);
    	$email = mysql_real_escape_string($email);
    	$name = mysql_real_escape_string($name);
    	$street1 = mysql_real_escape_string($street1);
    	$street2 = mysql_real_escape_string($street2);
    	$town = mysql_real_escape_string($town);
    	$county = mysql_real_escape_string($county);
    	$country = mysql_real_escape_string($country);
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
			$secondQuery = "INSERT INTO companies (userID, companyName) values('$userID','$name')";
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
     * add job position
     */
    public function createJobPosition($location_id, $contract_id, $salary, $length, $description, $postnow, $skillArray, $name) {
		$length = mysql_real_escape_string($length);
    	$description = mysql_real_escape_string($description);
    	$name = mysql_real_escape_string($name);
		$nowFormat = date('Y-m-d H:i:s');
        try {
			// First of all, let's begin a transaction
			mysql_query("BEGIN");
			// A set of queries; if one fails, an exception should be thrown
			$firstQuery = "INSERT INTO jobPositions (companyLocationID, positionName, contractTypeID, lengthOfContract, jobDescription, salary) values ('$location_id', '$name', '$contract_id', '$length', '$description','$salary')" ;
			mysql_query($firstQuery);
			$positionID = mysql_insert_id();
			$secondQuery = "INSERT INTO jobAdvertisements (positionID, dateActivated) values('$positionID','$nowFormat')";
			mysql_query($secondQuery);
			if ($postnow == 'no'){
				$thirdQuery="UPDATE jobAdvertisements SET dateDeactivated='$nowFormat' WHERE positionID='$positionID'";
				mysql_query($thirdQuery);
			}
			$N = count($skillArray);
			for($i=0; $i < $N; $i++){
				$this->addPositionSkills($positionID, (int) $skillArray[$i]);
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
     * add employer location
     */
    public function addLocation($employer_id, $street1, $street2, $town, $county, $country) {
    	$street1 = mysql_real_escape_string($street1);
    	$street2 = mysql_real_escape_string($street2);
    	$town = mysql_real_escape_string($town);
    	$county = mysql_real_escape_string($county);
    	$country = mysql_real_escape_string($country);
		$query = "INSERT INTO companyLocations (companyID, addressStreet1, addressStreet2, addressTown, addressCounty, addressCountry) values('$employer_id','$street1', '$street2', '$town', '$county', '$country')";
		mysql_query($query);
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
				$row_array['applicationID'] = $row['application_id'];
				$row_array['positionName'] = $row['positionName'];
				$date = date("d/m/Y h:i", strtotime($row['date']));
				$row_array['date'] = $date;
				$row_array['coverNote'] = $row['coverNote'];
				$contractID = $row['contractTypeID'];
				$result2 = mysql_query("SELECT contractName FROM contractTypes WHERE contract_id = '$contractID'") or die(mysql_error());
				// check for result
				$no_of_rows = mysql_num_rows($result2);
				if ($no_of_rows > 0) {
					$result2 = mysql_fetch_array($result2);
					$row_array['contract'] = $result2['contractName'];
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
     * Get employer applications
     */
    public function getApplicantsForPosition($position_id) {
        $result = mysql_query("SELECT * "
        				."FROM jobApplications "
        				."INNER JOIN jobPositions "
        				."ON jobApplications.positionID=jobPositions.position_id "
        				."WHERE jobPositions.position_id = '$position_id' "
        				."ORDER BY jobApplications.date") or die(mysql_error());
        // check for result
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            $return_arr = array();
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
				$position_id = $row['positionID'];
				$jobSeekerID = $row['jobSeekerID'];
				$row_array['jobSeekerID'] = $jobSeekerID;
				$row_array['positionID'] = $position_id;
				$row_array['positionName'] = $row['positionName'];
				$row_array['applicationID'] = $row['application_id'];
				$date = date("d/m/Y h:i", strtotime($row['date']));
				$row_array['date'] = $date;
				$row_array['coverNote'] = $row['coverNote'];
				$result2 = mysql_query("SELECT * FROM jobSeekers INNER JOIN users ON jobSeekers.userID=users.user_id WHERE jobSeekers.jobSeeker_id = '$jobSeekerID'") or die(mysql_error());
				// check for result
				$no_of_rows = mysql_num_rows($result2);
				if ($no_of_rows > 0) {
					$result2 = mysql_fetch_array($result2);
					$row_array['jobSeekerName'] = $result2['fullName'];
					$row_array['jobSeekerLandline'] = $result2['landline'];
					$row_array['jobSeekerMobile'] = $result2['mobile'];
					$row_array['jobSeekerEmail'] = $result2['email'];
				}
				$row_array['reviewed'] = $row['reviewed'];
				$row_array['responded'] = $row['responded'];
				$row_array['rating'] = $row['rating'];
				array_push($return_arr,$row_array);
			}
			return $return_arr;
        } else {
            return array();
        }
    }

    /**
     * Get active employer applications
     */
    public function getActiveEmployerPositions($employer_id) {
        $result = mysql_query("SELECT * "
        				."FROM jobPositions "
        				."INNER JOIN jobAdvertisements "
        				."ON jobAdvertisements.positionID=jobPositions.position_id "
        				."INNER JOIN companyLocations "
        				."ON companyLocations.location_id=jobPositions.companyLocationID "
        				."WHERE (companyLocations.companyID = '$employer_id' "
        				."AND jobAdvertisements.dateDeactivated is NULL)") or die(mysql_error());
        // check for result
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            $return_arr = array();
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
				$position_id = $row['position_id'];
				$location_id = $row['companyLocationID'];
				$row_array['address'] = $this->getCompanyLocationAddress($location_id);
				$row_array['positionID'] = $position_id;
				$row_array['positionName'] = $row['positionName'];
				$row_array['ad_id'] = $row['ad_id'];
				array_push($return_arr,$row_array);
			}
			return $return_arr;
        } else {
            return array();
        }
    }

    /**
     * Get active job postings
     */
    public function getActivePositions() {
        $result = mysql_query("SELECT * "
        				."FROM jobPositions "
        				."INNER JOIN jobAdvertisements "
        				."ON jobAdvertisements.positionID=jobPositions.position_id "
        				."INNER JOIN companyLocations "
        				."ON companyLocations.location_id=jobPositions.companyLocationID "
        				."INNER JOIN companies "
        				."ON companies.company_id=companyLocations.companyID "
        				."WHERE jobAdvertisements.dateDeactivated is NULL "
        				."ORDER BY jobAdvertisements.dateActivated DESC") or die(mysql_error());
        // check for result
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            $return_arr = array();
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
				$position_id = $row['position_id'];
				$row_array['companyName'] = $row['companyName'];
				$location_id = $row['companyLocationID'];
				$row_array['address'] = $this->getCompanyLocationAddress($location_id);
				$row_array['positionID'] = $position_id;
				$row_array['positionName'] = $row['positionName'];
				$row_array['ad_id'] = $row['ad_id'];
				$row_array['skillArray'] = $this->getPositionSkills($position_id);
				$row_array['salary'] = $row['salary'];
				$row_array['jobDescription'] = $row['jobDescription'];
				$date = date("d/m/Y h:i", strtotime($row['dateActivated']));
				$row_array['dateActivated'] = $date;
				$row_array['lengthOfContract'] = $row['lengthOfContract'];
				$contractID = $row['contractTypeID'];
				$result2 = mysql_query("SELECT contractName FROM contractTypes WHERE contract_id = '$contractID'") or die(mysql_error());
				// check for result
				$no_of_rows = mysql_num_rows($result2);
				if ($no_of_rows > 0) {
					$result2 = mysql_fetch_array($result2);
					$row_array['contract'] = $result2['contractName'];
				}
				array_push($return_arr,$row_array);
			}
			return $return_arr;
        } else {
            return array();
        }
    }

    /**
     * Get inactive employer applications
     */
    public function getInactiveEmployerPositions($employer_id) {
        $result = mysql_query("SELECT * "
        				."FROM jobPositions "
        				."INNER JOIN jobAdvertisements "
        				."ON jobAdvertisements.positionID=jobPositions.position_id "
        				."INNER JOIN companyLocations "
        				."ON companyLocations.location_id=jobPositions.companyLocationID "
        				."WHERE (companyLocations.companyID = '$employer_id' "
        				."AND jobAdvertisements.dateDeactivated is NOT NULL)") or die(mysql_error());
        // check for result
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            $return_arr = array();
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
				$position_id = $row['position_id'];
				$location_id = $row['companyLocationID'];
				$row_array['address'] = $this->getCompanyLocationAddress($location_id);
				$row_array['positionID'] = $position_id;
				$row_array['positionName'] = $row['positionName'];
				$row_array['ad_id'] = $row['ad_id'];
				array_push($return_arr,$row_array);
			}
			return $return_arr;
        } else {
            return array();
        }
    }

    /**
     * Get info for job position
     */
    public function getPositionInformation($position_id) {
        $result = mysql_query("SELECT * "
        				."FROM jobPositions "
        				."INNER JOIN companyLocations "
        				."ON companyLocations.location_id=jobPositions.companyLocationID "
        				."INNER JOIN companies "
        				."ON companies.company_id=companyLocations.companyID "
        				."INNER JOIN jobAdvertisements "
        				."ON jobAdvertisements.positionID=jobPositions.position_id "
        				."WHERE jobPositions.position_id= '$position_id'") or die(mysql_error());
        // check for result
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            $return_arr = array();
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
				$position_id = $row['position_id'];
				$location_id = $row['companyLocationID'];
				$row_array['address'] = $this->getCompanyLocationAddress($location_id);
				$row_array['positionID'] = $position_id;
				$row_array['positionName'] = $row['positionName'];
				$row_array['companyName'] = $row['companyName'];
				$row_array['dateActivated'] = date("d/m/Y h:i", strtotime($row['dateActivated']));
				$row_array['dateDeactivated'] = date("d/m/Y h:i", strtotime($row['dateDeactivated']));
				$row_array['coverNote'] = $row['coverNote'];
				$contractID = $row['contractTypeID'];
				$result2 = mysql_query("SELECT contractName FROM contractTypes WHERE contract_id = '$contractID'") or die(mysql_error());
				// check for result
				$no_of_rows = mysql_num_rows($result2);
				if ($no_of_rows > 0) {
					$result2 = mysql_fetch_array($result2);
					$row_array['contract'] = $result2['contractName'];
				}
				$row_array['skillArray'] = $this->getPositionSkills($position_id);
				$row_array['lengthOfContract'] = $row['lengthOfContract'];
				$row_array['jobDescription'] = $row['jobDescription'];
				$row_array['salary'] = $row['salary'];
				$row_array['reviewed'] = $row['reviewed'];
				$row_array['responded'] = $row['responded'];
				$row_array['rating'] = $row['rating'];
				array_push($return_arr,$row_array);
			}
			return $return_arr;
        } else {
            return array();
        }
    }

    /**
     * Get company locations
     */
    public function getCompanyLocations($company_id) {
        $result = mysql_query("SELECT * FROM companyLocations WHERE companyID = '$company_id'") or die(mysql_error());
        // check for result
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            $return_arr = array();
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
				$returnString = '';
				if (strlen($row['addressStreet1'])>0){
					$returnString .= $row['addressStreet1'] .", ";
				}
				if (strlen($row['addressStreet2'])>0){
					$returnString .= $row['addressStreet2'] .", ";
				}
				if (strlen($row['addressTown'])>0){
					$returnString .= $row['addressTown'] .", ";
				}
				if (strlen($row['addressCounty'])>0){
					$returnString .= $row['addressCounty'] .", ";
				}
				if (strlen($row['addressCountry'])>0){
					$returnString .= $row['addressCountry'] .". ";
				}
				$row_array['address']=$returnString;
				$row_array['location_id']=$row['location_id'];
				array_push($return_arr,$row_array);
			}
			return $return_arr;
        } else {
            return array();
        }
    }


    /**
     * Get contract types
     */
    public function getContractTypes() {
        $result = mysql_query("SELECT * FROM contractTypes") or die(mysql_error());
        // check for result
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            $return_arr = array();
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
				$row_array['name']=$row['contractName'];
				$row_array['contract_id']=$row['contract_id'];
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
				array_push($return_arr,$row['skillName']);
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
			return $result['companyName'];
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
				array_push($return_arr,$row['skillName']);
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
     * add user skills
     */
    public function addPositionSkills($position_id, $skill_id) {
        $result = @mysql_query("INSERT INTO positionSkills (skillID, positionID) values ('$skill_id','$position_id')");
    }

    /**
     * remove user skills
     */
    public function deleteUserSkills($jobSeeker_id) {
        $result = @mysql_query("DELETE FROM jobSeekerSkills WHERE jobSeekerID='$jobSeeker_id'");
    }

    /**
     * rate application
     */
    public function rateApplication($application_id, $rating) {
        $result = @mysql_query("UPDATE jobApplications SET rating='$rating', reviewed=1 WHERE application_id='$application_id'");
    }

    /**
     * responded to application
     */
    public function respondToApplication($application_id ) {
        $result = @mysql_query("UPDATE jobApplications SET responded=1 WHERE application_id='$application_id'");
    }

    /**
     * apply for job
     */
    public function applyForJob($coverNote, $position_id, $jobSeekerID) {
    	$coverNote = mysql_real_escape_string($coverNote);
    	$nowFormat = date('Y-m-d H:i:s');
    	$query = "INSERT INTO jobApplications (positionID, jobSeekerID, date, coverNote, reviewed, responded) VALUES('$position_id','$jobSeekerID','$nowFormat','$coverNote',0,0)";
        $result = mysql_query($query)or die(mysql_error());
    }

    /**
     * deactivate ad
     */
    public function deactivateAd($position_id) {
    	$nowFormat = date('Y-m-d H:i:s');
    	$result = mysql_query("SELECT * "
        				."FROM jobAdvertisements "
        				."INNER JOIN jobPositions "
        				."ON jobAdvertisements.positionID=jobPositions.position_id "
        				."WHERE jobPositions.position_id = '$position_id'") or die(mysql_error());
        // check for result
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            $result = mysql_fetch_array($result);
			$ad_id = $result['ad_id'];
			@mysql_query("UPDATE jobAdvertisements SET dateDeactivated='$nowFormat' WHERE ad_id='$ad_id'");
        }
    }

    /**
     * activate ad
     */
    public function activateAd($position_id) {
    	$nowFormat = date('Y-m-d H:i:s');
    	$result = mysql_query("SELECT * "
        				."FROM jobAdvertisements "
        				."INNER JOIN jobPositions "
        				."ON jobAdvertisements.positionID=jobPositions.position_id "
        				."WHERE jobPositions.position_id = '$position_id'") or die(mysql_error());
        // check for result
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            $result = mysql_fetch_array($result);
			$ad_id = $result['ad_id'];
			@mysql_query("UPDATE jobAdvertisements SET dateActivated='$nowFormat', dateDeactivated=Null WHERE ad_id='$ad_id'");
        }
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