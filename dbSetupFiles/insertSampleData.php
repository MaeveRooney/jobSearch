<?
$db;

require_once 'DB_Connect.php';
// connecting to database
$db = new DB_Connect();
$db->connect();

storeUser('johnsmith','example@email.com','secret1');
storeUser('johndoe','example2@email.com','secret1');
storeUser('janesmith','example3@email.com','secret1');
storeUser('fredwhite','example4@email.com','secret1');

$insertjobSeeker="INSERT INTO jobSeekers(userID, title, fullName, addressStreet1, addressStreet2, addressTown, addressCounty, addressCountry, landline, mobile) VALUES(1, 'Mrs', 'Maeve Tracy','1 Apple Street','Apple Way','Orchard Town','County Pie','Ireland','01 555 3321', '086 000 8888')";
mysql_query($insertjobSeeker);
$insertjobSeeker="INSERT INTO jobSeekers(userID, title, fullName, addressStreet1, addressStreet2, addressTown, addressCounty, addressCountry, landline, mobile) VALUES(2, 'Mr', 'Ian Tracy','2 Apple Street','Apple Way','Orchard Town','County Pie','Ireland','01 555 3322', '086 111 8888')";
mysql_query($insertjobSeeker);


$nowFormat = date('Y-m-d H:i:s');


function storeUser($username, $email, $password) {
        $hash = hashSSHA($password);
        $encrypted_password = $hash["encrypted"]; // encrypted password
        $salt = $hash["salt"]; // salt
        $result = mysql_query("INSERT INTO users(username, email, encrypted_password, salt) VALUES('$username', '$email', '$encrypted_password', '$salt')");
        // check for successful store
        if ($result) {
        } else {
            return false;
        }
}

 /**
     * Encrypting password
     * @param password
     * returns salt and encrypted password
     */
function hashSSHA($password) {

        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }

echo "Data Inserted! Boom";

$db->close();
?>