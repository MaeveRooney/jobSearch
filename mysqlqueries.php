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
        				."FROM companies "
        				."INNER JOIN companyLocations "
        				."ON companies.company_id=companyLocations.companyID "
        				."WHERE companyLocations.location_id = '$jobSeeker_id'") or die(mysql_error());
        // check for result
        $no_of_rows = mysql_num_rows($result);
        echo $no_of_rows;
        if ($no_of_rows > 0) {
            $result = mysql_fetch_array($result);
			return $result['name'];
        }
    }

}

$newclass = new userFunctions();
echo $newclass->getUserSkills(1);

?>