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

// Fetching unique faculties for selection
$facultyQuery = "SELECT DISTINCT name FROM feeds";
$facultyResult = $conn->query($facultyQuery);

// Fetching unique years for selection
$yearQuery = "SELECT DISTINCT year FROM feeds";
$yearResult = $conn->query($yearQuery);

// Check if the form is submitted to filter data
$selectedFaculty = "";
$selectedSubject = "";
$selectedYear = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['faculty'])) {
        $selectedFaculty = $_POST['faculty'];
    }
    if (!empty($_POST['subject'])) {
        $selectedSubject = $_POST['subject'];
    }
    if (!empty($_POST['year'])) {
        $selectedYear = $_POST['year'];
    }
}

// Fetch data from the database for the selected faculty, subject, and year
$sql = "SELECT q1, q2, q3, q4, q5, q6, q7, q8, q9, q10, q11, q12 FROM feeds WHERE name = ? AND subject = ? AND year = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $selectedFaculty, $selectedSubject, $selectedYear);
$stmt->execute();
$result = $stmt->get_result();

$responses = array(
    '1' => 0,
    '2' => 0,
    '3' => 0,
    '4' => 0,
    '5' => 0
);

$totalResponses = 0;

// Process fetched data
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        foreach ($row as $question => $answer) {
            if (in_array($answer, ['1', '2', '3', '4', '5'])) {
                $responses[$answer]++;
                $totalResponses++;
            }
        }
    }
}

$percentages = array();
foreach ($responses as $key => $value) {
    $percentages[$key] = ($totalResponses > 0) ? ($value / $totalResponses) * 100 : 0;
}

$stmt->close();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Feedback Pie Chart</title>
    <link href="style.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <span class="SubHead"><center>Student Feedback Responses</center></span>
    </br>    

    <center>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <select name="faculty">
        <option value="">Select Faculty</option> <!-- Default blank option -->
        <?php while ($row = $facultyResult->fetch_assoc()) { ?>
            <option value="<?php echo $row['name']; ?>" <?php if ($row['name'] === $selectedFaculty) echo 'selected="selected"'; ?>><?php echo $row['name']; ?></option>
        <?php } ?>
    </select>
    
    <!-- Fetching subjects based on selected faculty -->
    <?php if (!empty($selectedFaculty)) { ?>
        <select name="subject">
            <option value="">Select Subject</option> <!-- Default blank option -->
            <?php
            $subjectQuery = "SELECT DISTINCT subject FROM feeds WHERE name = '$selectedFaculty'";
            $subjectResult = $conn->query($subjectQuery);
            while ($row = $subjectResult->fetch_assoc()) {
            ?>
                <option value="<?php echo $row['subject']; ?>" <?php if ($row['subject'] === $selectedSubject) echo 'selected="selected"'; ?>><?php echo $row['subject']; ?></option>
            <?php } ?>
        </select>
    <?php } ?>

    <!-- Fetching years for selection -->
    <select name="year">
        <option value="">Select Year</option> <!-- Default blank option -->
        <?php while ($row = $yearResult->fetch_assoc()) { ?>
            <option value="<?php echo $row['year']; ?>" <?php if ($row['year'] === $selectedYear) echo 'selected="selected"'; ?>><?php echo $row['year']; ?></option>
        <?php } ?>
    </select>

    <input type="submit" value="Filter">
</form>

<br>

<input type="button" onClick="window.location='feeds.php'" value="BACK">
    
<div id="chartContainer" style="width: 40%;">
    <canvas id="feedbackChart" width="50px" height="50px"></canvas>
</div>
</center>

<script>
    var data = <?php echo json_encode(array_values($percentages)); ?>;
    var ctx = document.getElementById('feedbackChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['1.Very Poor', '2.Poor', '3.Average', '4.Good', '5.Excellent'],
            datasets: [{
                data: data,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.7)', // Very Poor
                    'rgba(54, 162, 235, 0.7)', // Poor
                    'rgba(255, 206, 86, 0.7)', // Average
                    'rgba(75, 192, 192, 0.7)', // Good
                    'rgba(153, 102, 255, 0.7)' // Excellent
                ],
            }]
        },
        options: {
            // Chart options here
        }
    });
</script>

</body>
</html>
