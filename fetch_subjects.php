<?php
include("configASL.php");

if (isset($_GET['year'])) {
    $selectedYear = $_GET['year'];
    $subjectsQuery = mysqli_query($al, "SELECT subjects FROM faculty WHERE year = '$selectedYear'");
    
    $foundSubjects = false; // Flag to track if any subjects are found
    
    echo '<table>';
   
    while ($subjectRow = mysqli_fetch_assoc($subjectsQuery)) {
        $subjects = explode(', ', $subjectRow['subjects']);
        foreach ($subjects as $subject) {
            echo '<tr>';
            echo '<td><input type="checkbox" name="subjects[]" value="' . $subject . '"></td>';
            echo '<td>' . $subject . '</td>';
            echo '</tr>';
            $foundSubjects = true; // Set the flag to true if subjects are found
        }
    }

    echo '</table>';

    if (!$foundSubjects) {
        echo 'No subjects found for the selected year.';
    }
}
?>
