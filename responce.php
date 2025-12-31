<?php
include "configASL.php";
session_start();

if (!isset($_SESSION['username'])) {
    header("location:index.php");
    exit;
}

// Check if data is received from the form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $selected_name = $_SESSION['selected_faculty_name'];
    $subject = $_SESSION['selected_subject']; // Change to selected_subject
    $roll = $_SESSION['selected_roll'];
    $sem = $_SESSION['selected_sem'];
    $q1 = $_POST['q1'];
    $q2 = $_POST['q2'];
    $q3 = $_POST['q3'];
    $q4 = $_POST['q4'];
    $q5 = $_POST['q5'];
    $q6 = $_POST['q6'];
    $q7 = $_POST['q7'];
    $q8 = $_POST['q8'];
    $q9 = $_POST['q9'];
    $q10 = $_POST['q10'];
    $q11 = $_POST['q11'];
    $q12 = $_POST['q12'];

    // Retrieve the year of the student from the database
    $year_query = mysqli_query($al, "SELECT year FROM student WHERE roll = '$roll'");
    $year_result = mysqli_fetch_assoc($year_query);
    $year = $year_result['year'];

    // Retrieve faculty_id from the faculty table based on selected_name
    $faculty_query = mysqli_query($al, "SELECT faculty_id FROM faculty WHERE name = '$selected_name'");
    $faculty_result = mysqli_fetch_assoc($faculty_query);
    $faculty_id = $faculty_result['faculty_id'];

    // Calculate total and percentage
    $total = $q1 + $q2 + $q3 + $q4 + $q5 + $q6 + $q7 + $q8 + $q9 + $q10 + $q11 + $q12;
    $percent = ($total / 60) * 100;

    // Insert data into the feeds table
    $query = "INSERT INTO feeds (id, faculty_id, name, subject, roll, year, sem, q1, q2, q3, q4, q5, q6, q7, q8, q9, q10, q11, q12, total, percent) 
              VALUES ('$id', '$faculty_id', '$selected_name', '$subject', '$roll', '$year', '$sem', '$q1', '$q2', '$q3', '$q4', '$q5', '$q6', '$q7', '$q8', '$q9', '$q10', '$q11', '$q12', '$total', '$percent')";

    $result = mysqli_query($al, $query);

    if ($result) {
        ?>
        <script type="text/javascript">
            alert('Feedback successfully submitted');
            window.location = 'feedstep1.php';
        </script>
        <?php
    } else {
        echo "Error: " . mysqli_error($al);
    }
} else {
    echo "No data received from the form.";
}
?>
