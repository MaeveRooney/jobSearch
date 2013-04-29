<?
$db;

require_once 'DB_Connect.php';
// connecting to database
$db = new DB_Connect();
$db->connect();

mysql_query('DROP TABLE IF EXISTS `maeveroo_jobsearch`.`positionSkills`') or die(mysql_error());
mysql_query('DROP TABLE IF EXISTS `maeveroo_jobsearch`.`contractTypes`') or die(mysql_error());
mysql_query('DROP TABLE IF EXISTS `maeveroo_jobsearch`.`jobAdvertisements`') or die(mysql_error());
mysql_query('DROP TABLE IF EXISTS `maeveroo_jobsearch`.`jobApplications`') or die(mysql_error());
mysql_query('DROP TABLE IF EXISTS `maeveroo_jobsearch`.`jobPositions`') or die(mysql_error());
mysql_query('DROP TABLE IF EXISTS `maeveroo_jobsearch`.`companyLocations`') or die(mysql_error());
mysql_query('DROP TABLE IF EXISTS `maeveroo_jobsearch`.`jobSeekerSkills`') or die(mysql_error());
mysql_query('DROP TABLE IF EXISTS `maeveroo_jobsearch`.`skills`') or die(mysql_error());
mysql_query('DROP TABLE IF EXISTS `maeveroo_jobsearch`.`companies`') or die(mysql_error());
mysql_query('DROP TABLE IF EXISTS `maeveroo_jobsearch`.`jobSeekers`') or die(mysql_error());
mysql_query('DROP TABLE IF EXISTS `maeveroo_jobsearch`.`users`') or die(mysql_error());


echo "tables dropped";

$db->close();
?>
