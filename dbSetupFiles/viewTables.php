<?php
$db;

require_once 'DB_Connect.php';
// connecting to database
$db = new DB_Connect();
$db->connect();

$result = mysql_query("SELECT * FROM users");

$num=mysql_numrows($result);

echo "<h2>users</h2>";
echo "<table border='1'>
<tr>
<th>ID</th>
<th>Username</th>
<th>email</th>
<th>password</th>
<th>salt</th>
</tr>";

while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>" . $row['user_id'] . "</td>";
  echo "<td>" . $row['username'] . "</td>";
  echo "<td>" . $row['email'] . "</td>";
  echo "<td>" . $row['encrypted_password'] . "</td>";
  echo "<td>" . $row['salt'] . "</td>";
  echo "</tr>";
  }
echo "</table></br></br>";

$result = mysql_query("SELECT * FROM jobSeekers");

$num=mysql_numrows($result);

echo "<h2>jobSeekers</h2>";
echo "<table border='1'>
<tr>
<th>ID</th>
<th>UserID</th>
<th>Title</th>
<th>full name</th>
<th>address street 1</th>
<th>address street 2</th>
<th>address town</th>
<th>address county</th>
<th>address country</th>
<th>landline</th>
<th>mobile</th>
</tr>";

while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>" . $row['jobSeeker_id'] . "</td>";
  echo "<td>" . $row['userID'] . "</td>";
  echo "<td>" . $row['title'] . "</td>";
  echo "<td>" . $row['fullName'] . "</td>";
  echo "<td>" . $row['addressStreet1'] . "</td>";
  echo "<td>" . $row['addressStreet2'] . "</td>";
  echo "<td>" . $row['addressTown'] . "</td>";
  echo "<td>" . $row['addressCounty'] . "</td>";
  echo "<td>" . $row['addressCountry'] . "</td>";
  echo "<td>" . $row['landline'] . "</td>";
  echo "<td>" . $row['mobile'] . "</td>";
  echo "</tr>";
  }
echo "</table></br></br>";

$result = mysql_query("SELECT * FROM companies");

$num=mysql_numrows($result);

echo "<h2>Companies</h2>";
echo "<table border='1'>
<tr>
<th>ID</th>
<th>UserID</th>
<th>name</th>
</tr>";

while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>" . $row['company_id'] . "</td>";
  echo "<td>" . $row['userID'] . "</td>";
  echo "<td>" . $row['name'] . "</td>";
  echo "</tr>";
  }
echo "</table></br></br>";

$result = mysql_query("SELECT * FROM companyLocations");

$num=mysql_numrows($result);

echo "<h2>CompanyLocations</h2>";
echo "<table border='1'>
<tr>
<th>ID</th>
<th>CompanyID</th>
<th>address street 1</th>
<th>address street 2</th>
<th>address town</th>
<th>address county</th>
<th>address country</th>
</tr>";

while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>" . $row['location_id'] . "</td>";
  echo "<td>" . $row['companyID'] . "</td>";
  echo "<td>" . $row['addressStreet1'] . "</td>";
  echo "<td>" . $row['addressStreet2'] . "</td>";
  echo "<td>" . $row['addressTown'] . "</td>";
  echo "<td>" . $row['addressCounty'] . "</td>";
  echo "<td>" . $row['addressCountry'] . "</td>";
  echo "</tr>";
  }
echo "</table></br></br>";

$result = mysql_query("SELECT * FROM contractTypes");

$num=mysql_numrows($result);

echo "<h2>contractTypes</h2>";
echo "<table border='1'>
<tr>
<th>ID</th>
<th>name</th>
<th>description</th>
</tr>";

while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>" . $row['contract_id'] . "</td>";
  echo "<td>" . $row['name'] . "</td>";
  echo "<td>" . $row['description'] . "</td>";
  echo "</tr>";
  }
echo "</table></br></br>";

$result = mysql_query("SELECT * FROM skills");

$num=mysql_numrows($result);

echo "<h2>Skills</h2>";
echo "<table border='1'>
<tr>
<th>ID</th>
<th>name</th>
<th>description</th>
</tr>";

while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>" . $row['skill_id'] . "</td>";
  echo "<td>" . $row['name'] . "</td>";
  echo "<td>" . $row['description'] . "</td>";
  echo "</tr>";
  }
echo "</table></br></br>";

$result = mysql_query("SELECT * FROM jobSeekerSkills");

$num=mysql_numrows($result);

echo "<h2>jobSeekerSkills</h2>";
echo "<table border='1'>
<tr>
<th>skillID</th>
<th>jobSeekerID</th>
</tr>";

while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>" . $row['skillID'] . "</td>";
  echo "<td>" . $row['jobSeekerID'] . "</td>";
  echo "</tr>";
  }
echo "</table></br></br>";

$result = mysql_query("SELECT * FROM positionSkills");

$num=mysql_numrows($result);

echo "<h2>positionSkills</h2>";
echo "<table border='1'>
<tr>
<th>skillID</th>
<th>positionID</th>
</tr>";

while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>" . $row['skillID'] . "</td>";
  echo "<td>" . $row['positionID'] . "</td>";
  echo "</tr>";
  }
echo "</table></br></br>";

$result = mysql_query("SELECT * FROM jobPositions");

$num=mysql_numrows($result);

echo "<h2>jobPositions</h2>";
echo "<table border='1'>
<tr>
<th>position_ID</th>
<th>companyLocationID</th>
<th>name</th>
<th>contractTypeID</th>
<th>lengthOfContract</th>
<th>jobDescription</th>
<th>salary</th>
</tr>";

while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>" . $row['position_id'] . "</td>";
  echo "<td>" . $row['companyLocationID'] . "</td>";
  echo "<td>" . $row['name'] . "</td>";
  echo "<td>" . $row['contractTypeID'] . "</td>";
  echo "<td>" . $row['lengthOfContract'] . "</td>";
  echo "<td>" . $row['jobDescription'] . "</td>";
  echo "<td>" . $row['salary'] . "</td>";
  echo "</tr>";
  }
echo "</table></br></br>";

$result = mysql_query("SELECT * FROM jobApplications");

$num=mysql_numrows($result);

echo "<h2>jobApplications</h2>";
echo "<table border='1'>
<tr>
<th>application_id</th>
<th>positionID</th>
<th>jobSeekerID</th>
<th>date</th>
<th>coverNote</th>
<th>reviewed</th>
<th>responded</th>
<th>rating</th>
</tr>";

while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>" . $row['application_id'] . "</td>";
  echo "<td>" . $row['positionID'] . "</td>";
  echo "<td>" . $row['jobSeekerID'] . "</td>";
  echo "<td>" . $row['date'] . "</td>";
  echo "<td>" . $row['coverNote'] . "</td>";
  echo "<td>" . $row['reviewed'] . "</td>";
  echo "<td>" . $row['responded'] . "</td>";
  echo "<td>" . $row['rating'] . "</td>";
  echo "</tr>";
  }
echo "</table></br></br>";

$result = mysql_query("SELECT * FROM jobAdvertisements");

$num=mysql_numrows($result);

echo "<h2>jobAdvertisements</h2>";
echo "<table border='1'>
<tr>
<th>ad_ID</th>
<th>positionID</th>
<th>dateActivated</th>
<th>dateDeactivated</th>
</tr>";

while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>" . $row['ad_id'] . "</td>";
  echo "<td>" . $row['positionID'] . "</td>";
  echo "<td>" . $row['dateActivated'] . "</td>";
  echo "<td>" . $row['dateDeactivated'] . "</td>";
  echo "</tr>";
  }
echo "</table></br></br>";



$db->close();
?>
