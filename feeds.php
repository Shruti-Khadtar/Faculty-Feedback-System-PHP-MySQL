<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ffs";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch distinct years from the feeds table
$yearsQuery = $conn->query("SELECT DISTINCT year FROM feeds");
$years = array();
while ($row = $yearsQuery->fetch_assoc()) {
    $years[] = $row['year'];
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $selectedYear = $_POST['selectedYear'];
    // Fetch data from the database based on the selected year
    $sql = "SELECT q1, q2, q3, q4, q5, q6, q7, q8, q9, q10, q11, q12, year, sem, roll, name, subject FROM feeds WHERE year = '$selectedYear'";
    $result = $conn->query($sql);
}

// Close MySQL connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Feedback Table with Dropdown</title>
    <link href="style.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .double-border-table {
            border-collapse: collapse;
            border: 3px double black;
        }

        .double-border-table th,
        .double-border-table td {
            border: 3px double black;
            padding: 10px;
        }
    </style>
</head>
<body>

<br>

<span class="SubHead"><center>Student Feedback Responses</center></span>

<br>

<form method="post" action="">
    <div align="center">
        <label for="selectedYear">Select Year:</label>
        <select name="selectedYear" id="selectedYear">
            <?php foreach ($years as $year) : ?>
                <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
            <?php endforeach; ?>
        </select>
        <input type="submit" value="show">
    </div>
</form>

<br>

<table class="double-border-table" align="center" cellpadding="30" cellspacing="30" style="width:100%">
    <tr style="font-weight:bold;">
        <td>Sr. No.</td>
        <td>Roll No.</td>
        <td>Year</td>
        <td>Sem</td>
        <td>Faculty</td>
        <td>Subject</td>
    </tr>
    <?php
    if (isset($result)) {
        $sr = 1;
        while ($j = $result->fetch_assoc()) :
    ?>
            <tr>
                <td><?php echo $sr; $sr++; ?></td>
                <td><?php echo $j['roll']; ?></td>
                <td><?php echo $j['year']; ?></td>
                <td><?php echo $j['sem']; ?></td>
                <td><?php echo $j['name']; ?></td>
                <td><?php echo $j['subject']; ?></td>
            </tr>
    <?php endwhile;
    } ?>
</table>

<br>

<div align="center">
    <button onclick="window.location.href='home.php'">Back</button>
    <button onclick="window.location.href='sample.php'">View Total Feedback</button>
</div>

</body>
</html>
