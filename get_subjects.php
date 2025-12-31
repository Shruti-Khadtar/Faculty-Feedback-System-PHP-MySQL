<!-- get_subjects.php -->
<?php
include("configASL.php");

if (isset($_GET['faculty'])) {
    $faculty_id = $_GET['faculty'];
    
    // Fetch subjects for the selected faculty from the database
    $facultyQuery = mysqli_query($al, "SELECT subjects FROM faculty WHERE faculty_id = '$faculty_id'");
    $faculty = mysqli_fetch_assoc($facultyQuery);
    
    // Convert the subjects string to an array
    $subjects = explode(',', $faculty['subjects']);
    
    // Output subjects as options
    foreach ($subjects as $subject) {
        echo "<option value='$subject'>$subject</option>";
    }
}
?>
