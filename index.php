<?php
include("configASL.php");
session_start();
if(isset($_SESSION['username']))
{
	header("location:home.php");
}
if(!empty($_POST))
{
	$username=mysqli_real_escape_string($al,$_POST['username']);
	$password=mysqli_real_escape_string($al,$_POST['password']);
	$sql=mysqli_query($al,"select * from alogin where username='$username' and password='$password'");
	if(mysqli_num_rows($sql)==1)
	{
		$_SESSION['username']=$_POST['username'];
		header("location:home.php");
	}
	else
	{
		?>
        <script type="text/javascript">
		alert("Incorrect Admin ID or Password");
		</script>
      <?php
	}
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Student Feedback System</title>
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
<span class="SubHead">Admin Login</span>
<form method="post" action="" >
<div id="table">
	<div class="tr">
		<div class="td">
        	<label>Admin ID : </label>
        </div>
        <div class="td">
			<input type="text" name="username" size="25" required />
        </div>
    </div>
    <div class="tr">
		<div class="td">
        	<label>Password : </label>
        </div>
        <div class="td">
			<input type="password" name="password" size="25" required />
        </div>
    </div>
</div>
		
        <div class="tdd">
        	<input type="submit" value="Login" />
        </div>
    
    <br>
</div>
</form>
<br>

<center>
<span class="SubHead" style="font-weight:100;"> Student Login <a href="slogin.php" class="link">Click Here</a></span>

</center>
</body>
</html>