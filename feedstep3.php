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
$selected_faculty_name = $_SESSION['selected_faculty_name'] ?? "";
$subjects_array = $_SESSION['subjects_array'] ?? [];

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
if (isset($_POST['name'])) {
    $_SESSION['selected_name'] = $_POST['name'];
    $selected_name = $_POST['name'];
}
if (isset($_POST['faculty_id'])) {
    $_SESSION['selected_faculty'] = $_POST['faculty_id'];
    $selected_faculty = $_POST['faculty_id'];

    // Fetch faculty details from the database
    $facultyQuery = mysqli_query($al, "SELECT name, subjects FROM faculty WHERE faculty_id = '$selected_faculty'");
    if ($facultyQuery) {
        $facultyData = mysqli_fetch_assoc($facultyQuery);
        $selected_faculty_name = $facultyData['name'];
        $selected_subjects_faculty = explode(',', $facultyData['subjects']); // Split faculty subjects into an array
        $_SESSION['selected_faculty_name'] = $selected_faculty_name;
        $_SESSION['subjects_array'] = $selected_subjects_faculty;
    }
}

// Fetch student's selected subjects from the "student" table
$studentRoll = mysqli_real_escape_string($al, $selected_roll);
$studentQuery = mysqli_query($al, "SELECT subjects FROM student WHERE roll = '$studentRoll'");
if ($studentQuery) {
    $studentData = mysqli_fetch_assoc($studentQuery);
    $studentSubjects = explode(',', $studentData['subjects']); // Split student subjects into an array

    // Fetch submitted subjects from the "feeds" table
    $feedbackQuery = mysqli_query($al, "SELECT DISTINCT subject FROM feeds");
    if ($feedbackQuery) {
        $submittedSubjects = [];
        while ($row = mysqli_fetch_assoc($feedbackQuery)) {
            $submittedSubjects[] = $row['subject'];
        }

        // Filter out subjects that are not in the faculty's subjects
        $subjects_array = array_intersect($studentSubjects, $_SESSION['subjects_array']);

        // Filter out subjects that have already been submitted as feedback
        $subjects_array = array_diff($subjects_array, $submittedSubjects);
    }
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
    <form method="post" action="feedform.php" onsubmit="return validateForm()">
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
                    <input type="text" name="faculty_name" value="<?php echo $selected_faculty_name; ?>" readonly />
                </div>
            </div>
            <div class="tr">
                <div class="td">
                    <label>Subjects : </label>
                </div>
                <div class="td">
                    <select name="subject" id="subject">
                        <?php
                        foreach ($subjects_array as $subject) {
                            echo "<option value='$subject'>$subject</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="tdd">
            <input type="submit" value="NEXT" />
            <input type="button" onClick="window.location='feedstep2.php'" value="BACK">
        </div>
    </form>
    <script>
        function validateForm() {
            var selectedSubject = document.getElementById('subject').value;
            if (selectedSubject === '' || selectedSubject === 'NA') {
                alert('Please select a Subject');
                return false; // Prevent form submission
            }
            return true; // Allow form submission
        }
    </script>
</body>
</html>
