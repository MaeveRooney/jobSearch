<?
$db;

require_once 'DB_Connect.php';
// connecting to database
$db = new DB_Connect();
$db->connect();

$createUserTable="CREATE TABLE users (id int(6) NOT NULL auto_increment, username varchar(15) NOT NULL UNIQUE,
	email varchar(50) NOT NULL UNIQUE,encrypted_password varchar(80) not null, salt varchar(10) not null,PRIMARY KEY (id))";
mysql_query($createUserTable);

$createCompanyTable="CREATE TABLE companies (id int(6) NOT NULL auto_increment, userID int(6), name varchar(50), PRIMARY KEY (id), FOREIGN KEY (userID) REFERENCES users(id))";
mysql_query($createCompanyTable);

$createJobSeekerTable="CREATE TABLE jobSeekers (id int(6) NOT NULL auto_increment, userID int(6), title varchar(10), fullName varchar(50), addressStreet1 varchar(50), addressStreet2 varchar(50), addressTown varchar(50), addressCounty varchar(50), addressCountry varchar(50), landline varchar(20), mobile varchar(20), PRIMARY KEY (id), FOREIGN KEY (userID) REFERENCES users(id))";
mysql_query($createJobSeekerTable);

$createSkillsTables="CREATE TABLE skills (id int(6) NOT NULL auto_increment, name varchar(50), description varchar(100), PRIMARY KEY (id))";
mysql_query($createSkillsTables);

$createJobSeekerSkillsTable="CREATE TABLE jobSeekerSkills (skillsID int(6), jobseekerID int(6), FOREIGN KEY (skillsID) REFERENCES skills(id), FOREIGN KEY (jobSeekerID) REFERENCES jobSeeker(id), PRIMARY KEY (skillsID, jobSeekerID))";
mysql_query($createJobSeekerSkillsTable);

$createCompanyLocationTable="CREATE TABLE companyLocations (id int(6) NOT NULL auto_increment, companyID int(6), addressStreet1 varchar(50), addressStreet2 varchar(50), addressTown varchar(50), addressCounty varchar(50), addressCountry varchar(50), PRIMARY KEY (id), FOREIGN KEY (companyID) REFERENCES companies(id))";
mysql_query($createCompanyLocationTable);

$createJobPosition="CREATE TABLE jobPositions (id int(6) NOT NULL auto_increment, companyLocationID int(6), name varchar(50), description varchar(100), FOREIGN KEY (companyLocationID) REFERENCES companyLocations(id), PRIMARY KEY (id))";
mysql_query($createJobPosition);

$createJobApplicationTable="CREATE TABLE jobApplications (id int(6) NOT NULL auto_increment, postionID int(6), jobSeekerID int(6), positionName varchar(50), contractType varchar(50), lengthOfContract varchar(50), jobDescription varchar(400), salary int(8), FOREIGN KEY (positionID) REFERENCES jobPositions(id), FOREIGN KEY (jobSeekerID) REFERENCES jobSeekers(id), PRIMARY KEY (id))";
mysql_query($createJobApplicationTable);

$createJobAdvertismentTable="CREATE TABLE jobAdvertisements (id int(6) NOT NULL auto_increment, postionID int(6), dateActivated date, dateDeactivated date, FOREIGN KEY (positionID) REFERENCES jobPositions(id), PRIMARY KEY (id))";
mysql_query($createJobAdvertismentTable);

$createPositionSkillsTable="CREATE TABLE positionSkills (skillsID int(6), positionID int(6), FOREIGN KEY (skillsID) REFERENCES skills(id), FOREIGN KEY (positionID) REFERENCES positions(id), PRIMARY KEY (skillsID, positionID))";
mysql_query($createPositionSkillsTable);

echo "tables created";

$db->close();
?>
