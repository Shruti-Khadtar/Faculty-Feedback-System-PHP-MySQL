<?php
include("configASL.php");
$id=$_GET['del'];
mysqli_query($al,"DELETE FROM `Student` WHERE id='$id'");
?>
<script type="text/javascript">
alert("Successfully deleted");
window.location='manageStudent.php';
</script>