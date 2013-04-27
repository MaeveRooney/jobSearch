<?php

class DB_Connect {

    // constructor
    function __construct() {

    }

    // destructor
    function __destruct() {
        // $this->close();
    }

    // Connecting to database
    public function connect() {
        // connecting to mysql

        $user="maeveroo";
		$password="maeve2124";
		$database="maeveroo_jobsearch";

		$con = mysql_connect("mysql.maeverooney.com",$user,$password);
		// selecting database
		@mysql_select_db($database) or die(mysql_error());

        // return database handler
        return $con;
    }

    // Closing database connection
    public function close() {
        mysql_close();
    }

}

?>