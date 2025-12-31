<?php
include("configASL.php");
session_start();
if(!isset($_SESSION['username']))
{
	header("location:index.php");
}
$username=$_SESSION['username'];
$x=mysqli_query($al,"select * from alogin where username='$username'");
$y=mysqli_fetch_array($x);

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Faculty Feedback System</title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>

<br>
<br>
<br>
<br>

<div id="content" align="center">
<br>
<br>
<span class="SubHead">Welcome Admin </span>
<br>
<br>


<a href="feeds.php">Feedback</a>
<br>
<br>
<a href="manageFaculty.php">Manage Faculty</a>
<br>
<br>
<a href="manageStudent.php">Manage Student</a>
<br>
<br>
<a href="logout.php">Logout</a>
<br>
<br>

</div>
</body>
</html>