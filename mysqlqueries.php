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
    public function getUserSkills() {
       $result = mysql_query("SELECT * FROM contractTypes") or die(mysql_error());
        // check for result
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            $return_arr = array();
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
				echo $row['contractName'];
				echo $row['contract_id'];
				array_push($return_arr,$row_array);
			}
			return $return_arr;
        } else {
            return array();
        }
    }

}

$newclass = new userFunctions();
echo $newclass->getUserSkills();

?>