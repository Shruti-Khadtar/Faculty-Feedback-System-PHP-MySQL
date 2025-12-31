<?php
include("configASL.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $roll = mysqli_real_escape_string($al, $_POST['roll']);
    $newPassword = mysqli_real_escape_string($al, $_POST['new']);
    $confirmPassword = mysqli_real_escape_string($al, $_POST['confirm']);

    // Additional validation if needed

    if ($newPassword === $confirmPassword) {
        // Do not hash the new password
        $plainTextPassword = $newPassword;

        // Update the user's password in the database
        $updateQuery = mysqli_query($al, "UPDATE student SET password='$plainTextPassword' WHERE roll='$roll'");

        if ($updateQuery) {
            echo '<script>alert("Password set successfully");</script>';
        } else {
            echo '<script>alert("Error setting password: ' . mysqli_error($al) . '");</script>';
        }
    } else {
        echo '<script>alert("Passwords do not match");</script>';
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Student Feedback System - Set New Password</title>
    <link href="style.css" rel="stylesheet" type="text/css" />
    <style>
        label {
            display: block;
            font-size: 16px;
            margin-bottom: 5px;
        }

        input,
        select {
            width: 70%;
            padding: 10px;
            border: 4px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"]:hover {
            background-color: #000000;
        }
    </style>
</head>

<body>
    <br>
    <br>
    <br>
    <br>

    <div id="content" align="center">
        <br>
        <br>
        <span class="SubHead">Change Password</span>
        <br>
        <br>
        <form method="post" action="">
            <div id="table">
                <div class="tr">
                    <div class="td">
                        <label>Roll No.: </label>
                    </div>
                    <div class="td">
                        <input type="roll" name="roll" size="25" required placeholder="Enter roll" />
                    </div>
                </div>
                <div class="tr">
                    <div class="td">
                        <label>New Password : </label>
                    </div>
                    <div class="td">
                        <input type="password" name="new" size="25" required placeholder="Enter New Password" />
                    </div>
                </div>
                <div class="tr">
                    <div class="td">
                        <label>Confirm Password : </label>
                    </div>
                    <div class="td">
                        <input type="password" name="confirm" size="25" required placeholder="Confirm Password" />
                    </div>
                </div>
            </div>

            <div class="tdd">
                <input type="submit" value="SET PASSWORD" />
            </div>
            <br>
            <input type="button" onClick="window.location='slogin.php'" value="BACK">
            <br>
            <br>
        </form>

        <br>
        <br>
        <br>

        <br>
        <br>
    </div>
</body>

</html>
