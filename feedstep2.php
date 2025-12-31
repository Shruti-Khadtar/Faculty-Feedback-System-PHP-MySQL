<?php
include("configASL.php");
session_start();

if (!isset($_SESSION['username'])) {
    header("location:index.php");
    exit;
}

// Initialize variables
$selected_roll = $_SESSION['selected_roll'] ?? "";
$selected_year = $_SESSION['selected_year'] ?? "";
$selected_sem = $_SESSION['selected_sem'] ?? "";
$selected_faculty_id = $_SESSION['selected_faculty_id'] ?? "";

// Check and set session variables based on POST data
if (isset($_POST['roll'])) {
    $_SESSION['selected_roll'] = $_POST['roll'];
    $selected_roll = $_POST['roll'];
}
if (isset($_POST['year'])) {
    $_SESSION['selected_year'] = $_POST['year'];
    $selected_year = $_POST['year'];
}
if (isset($_POST['sem'])) {
    $_SESSION['selected_sem'] = $_POST['sem'];
    $selected_sem = $_POST['sem'];
}
if (isset($_POST['faculty_id'])) {
    $_SESSION['selected_faculty_id'] = $_POST['faculty_id'];
    $selected_faculty_id = $_POST['faculty_id'];
}

// Function to fetch faculty names based on the selected year and semester
function fetchFaculties($al, $selected_year, $selected_sem, $selected_faculty_id) {
    $facultyOptions = "<option value='' disabled selected> - - Select Faculty - -</option>";

    $facultyQuery = mysqli_query($al, "SELECT * FROM faculty WHERE year = '$selected_year' AND sem = '$selected_sem'");
    while ($faculty = mysqli_fetch_assoc($facultyQuery)) {
        $selected = ($faculty['faculty_id'] == $selected_faculty_id) ? 'selected' : '';
        $facultyOptions .= "<option value='{$faculty['faculty_id']}' $selected>{$faculty['name']}</option>";
    }

    return $facultyOptions;
}
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
        <form method="post" action="feedstep3.php" onsubmit="return validateForm()">
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
                        <label>Year : </label>
                    </div>
                    <div class="td">
                        <input type="text" name="year" value="<?php echo $selected_year; ?>" readonly />
                    </div>
                </div>
                <div class="tr">
                    <div class="td">
                        <label>Sem : </label>
                    </div>
                    <div class="td">
                        <input type="text" name="sem" value="<?php echo $selected_sem; ?>" readonly />
                    </div>
                </div>
                <div class="tr">
                    <div class="td">
                        <label>Faculty : </label>
                    </div>
                    <div class="td">
                        <select name="faculty_id" id="faculty_id">
                            <?php echo fetchFaculties($al, $selected_year, $selected_sem, $selected_faculty_id); ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="tdd">
                <input type="submit" value="NEXT" />
                <input type="button" onClick="window.location='feedstep1.php'" value="BACK">
            </div>
        </form>
    </div>
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
