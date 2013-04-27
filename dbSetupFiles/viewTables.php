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
  echo "<td>" . $row['id'] . "</td>";
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
  echo "<td>" . $row['id'] . "</td>";
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



$db->close();
?>
