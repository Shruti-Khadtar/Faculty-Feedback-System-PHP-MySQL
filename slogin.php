<?php
include("configASL.php");
session_start();

if (isset($_SESSION['username'])) {
    header("location:slogin.php");
}

if (!empty($_POST)) {
    $roll = mysqli_real_escape_string($al, $_POST['roll']);
    $password = mysqli_real_escape_string($al, $_POST['password']);

    // Check if the entered credentials are valid
    $sql = mysqli_query($al, "SELECT * FROM student WHERE roll = '$roll' AND password = '$password'");

    if (mysqli_num_rows($sql) == 1) {
        $_SESSION['username'] = $roll; // Store roll in session
        header("location:feedstep1.php");
    } else {
        ?>
        <script type="text/javascript">
            alert("Incorrect Student ID or Password");
            window.location='slogin.php';
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
        <span class="SubHead">Student Login</span>
        <form method="post" action="">
            <div id="table">
                <div class="tr">
                    <div class="td">
                        <label>Student ID : </label>
                    </div>
                    <div class="td">
                        <input type="text" name="roll" size="25" required />
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
            <input type="button" onClick="window.location='index.php'" value="BACK"> <input type="submit" value="Login" />
            </div>
            <center>
                <span class="SubHead" style="font-weight:100;"><a href="changePass.php" class="link"><u>Forgot Password?</u></a></span>
            </center>
        </div>
    </form>
</body>
</html>
