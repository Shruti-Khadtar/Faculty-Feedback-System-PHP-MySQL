<?php
include "configASL.php";

if (isset($_POST['facultyId']) && isset($_POST['year'])) {
    $facultyId = $_POST['facultyId'];
    $year = $_POST['year'];

    // Fetch Sem based on the selected faculty and student's year
    $semQuery = mysqli_query($al, "SELECT DISTINCT sem FROM faculty WHERE faculty_id = '$facultyId' AND year = '$year'");
    $semOptions = '<option value="" disabled selected> - - Select Sem - -</option>';
    while ($semData = mysqli_fetch_assoc($semQuery)) {
        $semOptions .= "<option value='{$semData['sem']}'>{$semData['sem']}</option>";
    }

    echo $semOptions;
}
?>
