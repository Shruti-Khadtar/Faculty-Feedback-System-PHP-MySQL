<?php
include "configASL.php";

if (isset($_GET['roll']) && isset($_GET['year']) && isset($_GET['sem'])) {
    $selectedRoll = $_GET['roll'];
    $selectedYear = $_GET['year'];
    $selectedSemester = $_GET['sem'];

    // Fetch faculty based on the selected roll, year, and semester
    $facultyQuery = mysqli_query($al, "SELECT faculty_id, name FROM faculty WHERE year = '$selectedYear' AND sem = '$selectedSemester'");
    
    // Create HTML options for the faculty dropdown
    $options = '<option value="NA" disabled selected> - - Select Faculty - -</option>';
    while ($faculty = mysqli_fetch_assoc($facultyQuery)) {
        $options .= '<option value="' . $faculty['faculty_id'] . '">' . $faculty['name'] . '</option>';
    }

    // Echo the HTML options
    echo $options;
} else {
    // If parameters are not set, echo an error message
    echo 'Error: Roll, Year, or Semester not specified';
}
?>
