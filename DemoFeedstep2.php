<?php
include "configASL.php";
session_start();

if (isset($_POST['roll'])) {
    $_SESSION['selected_roll'] = $_POST['roll'];
    // Fetch roll number based on the selected id
    $selected_roll = $_POST['roll'];
    $query = "SELECT roll FROM student WHERE roll = '$selected_roll'";
    $result = mysqli_query($al, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        if ($row) {
            $_SESSION['selected_roll'] = $row['roll'];
        } else {
            // Handle the case where no matching roll is found
            echo "Error: No matching roll found for the selected id.";
            exit;
        }
    }
}

if (isset($_POST['faculty_id'])) {
    $_SESSION['faculty_id'] = $_POST['faculty_id'];
    // Fetch Faculty Name
    $nm = mysqli_fetch_array(mysqli_query($al, "SELECT * FROM faculty WHERE faculty_id='" . $_SESSION['faculty_id'] . "'"));
    $_SESSION['name'] = $nm['name'];
}

if (isset($_POST['subject'])) {
    $_SESSION['subject'] = $_POST['subject'];

    // Prepare and execute SQL INSERT query
    $roll = $_SESSION['selected_roll'];
    $facultyName = $_SESSION['name'];
    $subject = $_SESSION['subject'];

    $insertQuery = "INSERT INTO feeds (roll, name, subject) VALUES (?, ?, ?)";
    $stmt = $al->prepare($insertQuery);
    $stmt->bind_param("sss", $roll, $facultyName, $subject);
    $stmt->execute();
    $stmt->close();
}

// Fetch subjects that the student hasn't submitted feedback for
$roll = $_SESSION['selected_roll'];
$facultyId = $_SESSION['faculty_id'];
$studentSubjects = [];
$facultySubjects = [];

// Fetch subjects assigned to the student
$studentSubjectsQuery = mysqli_query($al, "SELECT subjects FROM student WHERE roll='$roll'");
$studentSubjectsRow = mysqli_fetch_assoc($studentSubjectsQuery);
if ($studentSubjectsRow) {
    $studentSubjects = explode(', ', $studentSubjectsRow['subjects']);
}

// Fetch subjects assigned to the faculty
$facultySubjectsQuery = mysqli_query($al, "SELECT subjects FROM faculty WHERE faculty_id='$facultyId'");
$facultySubjectsRow = mysqli_fetch_assoc($facultySubjectsQuery);
if ($facultySubjectsRow) {
    $facultySubjects = explode(', ', $facultySubjectsRow['subjects']);
}

// Fetch subjects for which the student has not submitted feedback
$submittedSubjectsQuery = mysqli_query($al, "SELECT DISTINCT subject FROM feeds WHERE roll='$roll' AND name IN (SELECT name FROM faculty WHERE faculty_id='$facultyId')");
$submittedSubjects = [];
while ($row = mysqli_fetch_assoc($submittedSubjectsQuery)) {
    $submittedSubjects[] = $row['subject'];
}

// Find the common subjects between student, faculty, and not submitted yet
$availableSubjects = array_intersect($studentSubjects, $facultySubjects, array_diff($facultySubjects, $submittedSubjects));
?>

<!doctype html>
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
<div id="content" align="center">
<br>
<br>
<form method="post" action="feedform.php" onsubmit="return validateForm()">
    <div id="table"> 
        <div class="tr">
            <div class="td">
                <label>Roll No :</label>
            </div>
            <div class="td">
                <input type="text" disabled size="25" value="<?php echo $_SESSION['selected_roll'];?>" />
            </div>
        </div>
        <div class="tr">
            <div class="td">
                <label>Faculty :</label>
            </div>
            <div class="td">
                <input type="text" disabled size="25" value="<?php echo $_SESSION['name'];?>" />
                <input type="hidden" value="<?php echo $_SESSION['faculty_id'];?>" name="faculty_id" />
            </div>
        </div>
        <div class="tr">
            <div class="td">
                <label>Subject :</label>
            </div>
            <div class="td">
                <select name="subject" id="subject">
                    <option value="NA" disabled selected> - - Select Subject - -</option>
                    <?php
                    foreach ($availableSubjects as $subject) {
                        echo "<option value='$subject'>$subject</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
    </div>
    <div class="tdd">
        <input type="button" onClick="window.location='DemoFeedstep1.php'" value="BACK">
        <input type="submit" value="NEXT" />
    </div>
    <br>
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
