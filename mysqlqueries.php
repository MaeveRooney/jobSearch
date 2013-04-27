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

}

$newclass = new userFunctions();
echo count($newclass->getUserSkills(1));

if (in_array("CSS",$newclass->getUserSkills(1)))
  {
  echo "CSS Match found";
  }
else
  {
  echo "CSS Match not found";
  }

if (in_array("C#",$newclass->getUserSkills(1)))
  {
  echo "C# Match found";
  }
else
  {
  echo "C# Match not found";
  }

if (in_array("Java",$newclass->getUserSkills(1)))
  {
  echo "Java Match found";
  }
else
  {
  echo "Java Match not found";
  }

?>