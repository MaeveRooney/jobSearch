<?
$db;

require_once 'DB_Connect.php';
// connecting to database
$db = new DB_Connect();
$db->connect();

$createUserTable="CREATE TABLE users (user_id int(6) NOT NULL auto_increment, username varchar(15) NOT NULL UNIQUE,
	email varchar(50) NOT NULL UNIQUE,encrypted_password varchar(80) not null, salt varchar(10) not null,PRIMARY KEY (user_id))";
mysql_query($createUserTable);

$createCompanyTable="CREATE TABLE companies (company_id int(6) NOT NULL auto_increment, userID int(6), name varchar(50), PRIMARY KEY (company_id), FOREIGN KEY (userID) REFERENCES users(user_id))";
mysql_query($createCompanyTable);

$createJobSeekerTable="CREATE TABLE jobSeekers (jobSeeker_id int(6) NOT NULL auto_increment, userID int(6), title varchar(10), fullName varchar(50), addressStreet1 varchar(50), addressStreet2 varchar(50), addressTown varchar(50), addressCounty varchar(50), addressCountry varchar(50), landline varchar(20), mobile varchar(20), PRIMARY KEY (jobSeeker_id), FOREIGN KEY (userID) REFERENCES users(user_id))";
mysql_query($createJobSeekerTable);

$createSkillsTables="CREATE TABLE skills (skill_id int(6) NOT NULL auto_increment, name varchar(50), description varchar(100), PRIMARY KEY (skill_id))";
mysql_query($createSkillsTables);

$createContractTables="CREATE TABLE contractTypes (contract_id int(6) NOT NULL auto_increment, name varchar(50), description varchar(100), PRIMARY KEY (contract_id))";
mysql_query($createContractTables);

$createJobSeekerSkillsTable="CREATE TABLE jobSeekerSkills (skillID int(6), jobSeekerID int(6), FOREIGN KEY (skillID) REFERENCES skills(skill_id), FOREIGN KEY (jobSeekerID) REFERENCES jobSeekers(jobSeeker_id), PRIMARY KEY (skillID, jobSeekerID))";
mysql_query($createJobSeekerSkillsTable);

$createCompanyLocationTable="CREATE TABLE companyLocations (location_id int(6) NOT NULL auto_increment, companyID int(6), addressStreet1 varchar(50), addressStreet2 varchar(50), addressTown varchar(50), addressCounty varchar(50), addressCountry varchar(50), PRIMARY KEY (location_id), FOREIGN KEY (companyID) REFERENCES companies(company_id))";
mysql_query($createCompanyLocationTable);

$createJobPosition="CREATE TABLE jobPositions (position_id int(6) NOT NULL auto_increment, companyLocationID int(6), name varchar(50), contractTypeID int(6), lengthOfContract varchar(20), jobDescription varchar(100), salary int(8), FOREIGN KEY (companyLocationID) REFERENCES companyLocations(location_id), FOREIGN KEY (contractTypeID) REFERENCES contractTypes(contract_id), PRIMARY KEY (position_id))";
mysql_query($createJobPosition);

$createJobApplicationTable="CREATE TABLE jobApplications (application_id int(6) NOT NULL auto_increment, positionID int(6), jobSeekerID int(6), date date, coverNote varchar(500), reviewed int(1), responded int(1), rating int(3), FOREIGN KEY (positionID) REFERENCES jobPositions(position_id), FOREIGN KEY (jobSeekerID) REFERENCES jobSeekers(jobSeeker_id), PRIMARY KEY (application_id))";
mysql_query($createJobApplicationTable);

$createJobAdvertismentTable="CREATE TABLE jobAdvertisements (ad_id int(6) NOT NULL auto_increment, positionID int(6), dateActivated date, dateDeactivated date, FOREIGN KEY (positionID) REFERENCES jobPositions(position_id), PRIMARY KEY (ad_id))";
mysql_query($createJobAdvertismentTable);

$createPositionSkillsTable="CREATE TABLE positionSkills (skillID int(6), positionID int(6), FOREIGN KEY (skillID) REFERENCES skills(skill_id), FOREIGN KEY (positionID) REFERENCES positions(position_id), PRIMARY KEY (skillID, positionID))";
mysql_query($createPositionSkillsTable);

echo "tables created";

$db->close();
?>
