<?php
include("configASL.php");

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $delete_query = mysqli_query($al, "DELETE FROM faculty WHERE faculty_id='$id'");

    if($delete_query) {
        echo '<script type="text/javascript">';
        echo 'alert("Successfully deleted");';
        echo 'window.location.href = "manageFaculty.php";';  // Replace with the actual page
        echo '</script>';
    } else {
        echo '<script type="text/javascript">';
        echo 'alert("Error deleting record");';
        echo 'window.location.href = "manageFaculty.php";';  // Replace with the actual page
        echo '</script>';
    }
} else {
    echo '<script type="text/javascript">';
    echo 'alert("Invalid request");';
    echo 'window.location.href = "manageFaculty.php";';  // Replace with the actual page
    echo '</script>';
}
?>
