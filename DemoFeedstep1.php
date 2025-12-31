<?php
include "configASL.php";
session_start();

if (!isset($_SESSION['username'])) {
    header("location:index.php");
    exit;
}

$selected_roll = $_SESSION['username'];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Student Feedback System</title>
    <link href="style.css" rel="stylesheet" type="text/css" />
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        form {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }

        label {
            display: block;
            font-size: 16px;
            margin-bottom: 5px;
        }

        input,
        select {
            width: 90%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-bottom: 10px;
        }

        input[type="submit"]:hover {
            background-color: #000000;
        }

        .t {
            font-family: "Segoe UI";
            font-weight: bold;
        }
    </style>
</head>
<body>
    <br>
    <br>
    <br>
    <div id="content" align="center">
        <br>
        <form method="post" action="DemoFeedstep2.php" onsubmit="return validateForm()">
            <div id="table"> 
                <div class="tr">
                    <div class="td">
                        <label>Roll No : </label>
                    </div>
                    <div class="td">
                        <input type="text" name="roll" value="<?php echo $selected_roll; ?>" readonly />
                    </div>
                </div>
                <div class="tr">
                    <div class="td">
                        <label>Faculty : </label>
                    </div>
                    <div class="td">
                        <select name="faculty_id" id="faculty_id" required>
                            <option value="" disabled selected> - - Select Faculty - -</option>
                            <?php
                            $facultyQuery = mysqli_query($al, "SELECT * FROM faculty");
                            while ($faculty = mysqli_fetch_assoc($facultyQuery)) {
                                echo "<option value='{$faculty['faculty_id']}'>{$faculty['name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="tdd">
                <input type="button" onClick="window.location='logout.php'" value="BACK">
                <input type="submit" value="NEXT" />
            </div>
        </form>
        <script>
        function validateForm() {
            var selectedFaculty = document.getElementById('faculty_id').value;
            if (selectedFaculty === '' || selectedFaculty === 'NA') {
                alert('Please select a Faculty');
                return false; // Prevent form submission
            }
            return true; // Allow form submission
        }
        </script>
    </body>
</html>
