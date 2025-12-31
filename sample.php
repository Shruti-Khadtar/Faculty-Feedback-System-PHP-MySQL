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

// Check if the form is submitted to filter data
$selectedFaculty = "";
$selectedSubject = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['faculty'])) {
        $selectedFaculty = $_POST['faculty'];
    }
    if (!empty($_POST['subject'])) {
        $selectedSubject = $_POST['subject'];
    }
}

// Fetch data from the database for the selected faculty and subject
$sql = "SELECT q1, q2, q3, q4, q5, q6, q7, q8, q9, q10, q11, q12 FROM feeds WHERE name = ? AND subject = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $selectedFaculty, $selectedSubject);
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
    <style>
        input,select {
            width: 50%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
    input[type="submit"]:hover {
            background-color: #000000;
        }
        
    </style>
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
    <?php
    // Fetch subjects based on selected faculty
    if (!empty($selectedFaculty)) {
        $subjectQuery = "SELECT DISTINCT subject FROM feeds WHERE name = '$selectedFaculty'";
        $subjectResult = $conn->query($subjectQuery);
        ?>
        <select name="subject">
            <option value="">Select Subject</option> <!-- Default blank option -->
            <?php while ($row = $subjectResult->fetch_assoc()) { ?>
                <option value="<?php echo $row['subject']; ?>" <?php if ($row['subject'] === $selectedSubject) echo 'selected="selected"'; ?>><?php echo $row['subject']; ?></option>
            <?php } ?>
        </select>
    <?php } ?>

    <input type="submit" value="show">
</form>


     <?php 
     $conn->close();
     ?>
      <br>
    <input type="button" onClick="window.location='feeds.php'" value="BACK">
            </br>
    <div id="chartContainer" style="width: 30%;">
        <canvas id="feedbackChart" width="40px" height="40px"></canvas>
    </div>
    </center>

<br>
<center>
    <input type="submit" value="View in Detail Responce" onClick="window.location='detailResponce.php'">    
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
            plugins: {
                legend: {
                    display: false // Set to false to hide the legend
                }
            },
        }
    });
    </script>

</body>
</html>
