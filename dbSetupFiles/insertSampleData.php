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
storeUser('fredblack','example5@email.com','secret1');

$insert="INSERT INTO jobSeekers(userID, title, fullName, addressStreet1, addressStreet2, addressTown, addressCounty, addressCountry, landline, mobile) VALUES(1, 'Mrs', 'John Smith','1 Apple Street','Apple Way','Orchard Town','County Pie','Ireland','01 555 3321', '086 000 8888')";
mysql_query($insert);
$insert="INSERT INTO jobSeekers(userID, title, fullName, addressStreet1, addressStreet2, addressTown, addressCounty, addressCountry, landline, mobile) VALUES(2, 'Mr', 'Jane Smith','2 Apple Street','Apple Way','Orchard Town','County Pie','Ireland','01 555 3322', '086 111 8888')";
mysql_query($insert);
$insert="INSERT INTO jobSeekers(userID, title, fullName, addressStreet1, addressStreet2, addressTown, addressCounty, addressCountry, landline, mobile) VALUES(4, 'Mr', 'Fred White','5 Main Street','Big Town','Capital City','County Dublin','Ireland','01 555 1111', '086 222 3333')";
mysql_query($insert);


$insert="INSERT INTO companies(userID, companyName) VALUES(3, 'Big Cheese Inc.')";
mysql_query($insert);

$insert="INSERT INTO companies(userID, companyName) VALUES(5, 'We Sell Stuff')";
mysql_query($insert);

$insert="INSERT INTO companyLocations(companyID, addressStreet1, addressStreet2, addressTown, addressCounty, addressCountry) VALUES(1, '1 Main Street','Big Town','Capital City','County Dublin','Ireland')";
mysql_query($insert);

$insert="INSERT INTO companyLocations(companyID, addressStreet1, addressStreet2, addressTown, addressCounty, addressCountry) VALUES(1, 'Suite 2','55 Long Street','New York','New York','USA')";
mysql_query($insert);

$insert="INSERT INTO companyLocations(companyID, addressStreet1, addressStreet2, addressTown, addressCounty, addressCountry) VALUES(2, 'Suite 5','55 Long Street','New York','New York','USA')";
mysql_query($insert);


$insert="INSERT INTO contractTypes (contractName, description) VALUES('Full Time','At least 39 hours a week')";
mysql_query($insert);

$insert="INSERT INTO contractTypes (contractName, description) VALUES('Part Time','Up to 20 hours a week')";
mysql_query($insert);

$insert="INSERT INTO contractTypes (contractName, description) VALUES('Flexi Time','Agreed period of work. Start and finish times vary')";
mysql_query($insert);

$insert="INSERT INTO contractTypes (contractName, description) VALUES('Temporary','Duration of Work is not permenant')";
mysql_query($insert);


$insert="INSERT INTO skills (skillName, description) VALUES('CSS','Cascading Style Sheets')";
mysql_query($insert);

$insert="INSERT INTO skills (skillName, description) VALUES('Java','programming language')";
mysql_query($insert);

$insert="INSERT INTO skills (skillName, description) VALUES('JavaScript','programming language')";
mysql_query($insert);

$insert="INSERT INTO skills (skillName, description) VALUES('C++','programming language')";
mysql_query($insert);

$insert="INSERT INTO skills (skillName, description) VALUES('C#','programming language')";
mysql_query($insert);

$insert="INSERT INTO skills (skillName, description) VALUES('Python','programming language')";
mysql_query($insert);

$insert="INSERT INTO skills (skillName, description) VALUES('PHP','programming language')";
mysql_query($insert);

$insert="INSERT INTO skills (skillName, description) VALUES('MySQL','Database Language')";
mysql_query($insert);

$insert="INSERT INTO skills (skillName, description) VALUES('SQLServer','Database Language')";
mysql_query($insert);

$insert="INSERT INTO skills (skillName, description) VALUES('Project Management','Project Management')";
mysql_query($insert);

$insert="INSERT INTO skills (skillName, description) VALUES('Team Management','Team Management')";
mysql_query($insert);

$insert="INSERT INTO skills (skillName, description) VALUES('Customer Service','Customer Service')";
mysql_query($insert);

$insert="INSERT INTO skills (skillName, description) VALUES('Database Management','Database Management')";
mysql_query($insert);

$insert="INSERT INTO skills (skillName, description) VALUES('Accounting','Accounting')";
mysql_query($insert);

$insert="INSERT INTO skills (skillName, description) VALUES('Cryptography','Cryptography')";
mysql_query($insert);


$insert="INSERT INTO jobSeekerSkills (skillID, jobSeekerID) VALUES(5,1)";
mysql_query($insert);

$insert="INSERT INTO jobSeekerSkills (skillID, jobSeekerID) VALUES(1,1)";
mysql_query($insert);


$insert="INSERT INTO jobPositions (companyLocationID, positionName, contractTypeID, lengthOfContract, jobDescription, salary) VALUES(1, 'Junior Accountant',1,'1 year','Assistant to head accountant. Needs to understand big number things and work in a team. Will be expected to learn fast a not steal things', 22000)";
mysql_query($insert);

$insert="INSERT INTO positionSkills (skillID, positionID) VALUES(12,1)";
mysql_query($insert);
$insert="INSERT INTO positionSkills (skillID, positionID) VALUES(14,1)";
mysql_query($insert);

$insert="INSERT INTO jobPositions (companyLocationID, positionName, contractTypeID, lengthOfContract, jobDescription, salary) VALUES(2, 'Junior Java Programmer',1,'2 years','Must understand Java to a high level. Previous experience is a must. We like nice people so mean people need not apply.', 32000)";
mysql_query($insert);

$insert="INSERT INTO positionSkills (skillID, positionID) VALUES(2,2)";
mysql_query($insert);
$insert="INSERT INTO positionSkills (skillID, positionID) VALUES(8,2)";
mysql_query($insert);
$insert="INSERT INTO positionSkills (skillID, positionID) VALUES(7,2)";
mysql_query($insert);
$insert="INSERT INTO positionSkills (skillID, positionID) VALUES(9,2)";
mysql_query($insert);

$insert="INSERT INTO jobPositions (companyLocationID, positionName, contractTypeID, lengthOfContract, jobDescription, salary) VALUES(3, 'Senior Accountant',1,'5 years','Be The head accountant. Needs to mega understand big number things and work in a team. Will be expected to learn fast and not steal things', 50000)";
mysql_query($insert);

$insert="INSERT INTO positionSkills (skillID, positionID) VALUES(12,3)";
mysql_query($insert);
$insert="INSERT INTO positionSkills (skillID, positionID) VALUES(14,3)";
mysql_query($insert);

$insert="INSERT INTO jobPositions (companyLocationID, positionName, contractTypeID, lengthOfContract, jobDescription, salary) VALUES(2, 'Head Honcho',1,'10 years','Rule us all', 1000000)";
mysql_query($insert);

$insert="INSERT INTO positionSkills (skillID, positionID) VALUES(5,4)";
mysql_query($insert);
$insert="INSERT INTO positionSkills (skillID, positionID) VALUES(4,4)";
mysql_query($insert);
$insert="INSERT INTO positionSkills (skillID, positionID) VALUES(9,4)";
mysql_query($insert);

$nowFormat = date('Y-m-d H:i:s');

$insert="INSERT INTO jobAdvertisements (positionID, dateActivated) VALUES (1,'$nowFormat')";
mysql_query($insert);
$insert="INSERT INTO jobAdvertisements (positionID, dateActivated) VALUES (2,'$nowFormat')";
mysql_query($insert);
$insert="INSERT INTO jobAdvertisements (positionID, dateActivated, dateDeactivated) VALUES (4,'$nowFormat','$nowFormat')";
mysql_query($insert);

$insert="INSERT INTO jobApplications (positionID, jobSeekerID, date, coverNote, reviewed, responded) VALUES (2,1,'$nowFormat','Please hire me. I need money.',0,0)";
mysql_query($insert);

$insert="INSERT INTO jobApplications (positionID, jobSeekerID, date, coverNote, reviewed, responded) VALUES (3,1,'$nowFormat','Please hire me. Im real good with numbers.',0,0)";
mysql_query($insert);

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