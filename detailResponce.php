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

// Initialize arrays to store data for each question
$questionsData = array();

// Process fetched data
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        foreach ($row as $column => $answer) {
            // Extract the question number (e.g., 'q1' from 'q1')
            $questionNumber = substr($column, 1);

            if (!isset($questionsData[$questionNumber])) {
                $questionsData[$questionNumber] = array(
                    '1' => 0,
                    '2' => 0,
                    '3' => 0,
                    '4' => 0,
                    '5' => 0
                );
            }

            if (in_array($answer, ['1', '2', '3', '4', '5'])) {
                $questionsData[$questionNumber][$answer]++;
            }
        }
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Feedback Pie Charts</title>
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
    <br>

    <center>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <select name="faculty">
                <option value="">Select Faculty</option>
                <?php
                while ($row = $facultyResult->fetch_assoc()) {
                    echo '<option value="' . $row['name'] . '" ';
                    if ($row['name'] === $selectedFaculty) echo 'selected="selected"';
                    echo '>' . $row['name'] . '</option>';
                }
                ?>
            </select>

            <?php if (!empty($selectedFaculty)) : ?>
                <?php
                // Fetch subjects based on selected faculty
                $subjectQuery = "SELECT DISTINCT subject FROM feeds WHERE name = '$selectedFaculty'";
                $subjectResult = $conn->query($subjectQuery);
                ?>
                <select name="subject">
                    <option value="">Select Subject</option>
                    <?php
                    while ($row = $subjectResult->fetch_assoc()) {
                        echo '<option value="' . $row['subject'] . '" ';
                        if ($row['subject'] === $selectedSubject) echo 'selected="selected"';
                        echo '>' . $row['subject'] . '</option>';
                    }
                    ?>
                </select>
            <?php endif; ?>

            <input type="submit" value="Show">
        </form>

        <?php
       $questionsQuery = "SELECT question_id, question FROM questions";
       $questionsResult = $conn->query($questionsQuery);
       
       // Check if there are questions in the result set
       if ($questionsResult->num_rows > 0) {
           // Fetch questions one by one
           while ($row = $questionsResult->fetch_assoc()) {
               $questionId = $row['question_id'];
               $question = $row['question'];
       
               // Output the question or perform other operations
               echo "<br> $question <br>";
       
               // Check if the questionId exists in $questionsData before using it
               if (isset($questionsData[$questionId])) {
                   // Display the question above the pie chart
                   echo '<div style="width: 10%; margin-top: 20px; text-align: center;">';
                   echo '<canvas id="feedbackChart' . $questionId . '" width="50px" height="50px"></canvas>';
                   echo '</div>';
       
                   // Use a check to ensure $questionsData[$questionId] is set
                   echo '<script>
                           var data' . $questionId . ' = ' . json_encode(array_values($questionsData[$questionId])) . ';
                           var ctx' . $questionId . ' = document.getElementById("feedbackChart' . $questionId . '").getContext("2d");
                           var myChart' . $questionId . ' = new Chart(ctx' . $questionId . ', {
                               type: "pie",
                               data: {
                                   labels: ["1.Very Poor", "2.Poor", "3.Average", "4.Good", "5.Excellent"],
                                   datasets: [{
                                       data: data' . $questionId . ',
                                       backgroundColor: [
                                           "rgba(255, 99, 132, 0.7)", // Very Poor
                                           "rgba(54, 162, 235, 0.7)", // Poor
                                           "rgba(255, 206, 86, 0.7)", // Average
                                           "rgba(75, 192, 192, 0.7)", // Good
                                           "rgba(153, 102, 255, 0.7)" // Excellent
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
                       </script>';
               } else {
                   echo " ";
               }
           }
       } else {
           echo "No questions found in the database.";
       }

        $stmt->close();
        $conn->close();
        ?>
        <br>
            <input type="button" onClick="window.location='sample.php'" value="BACK">
        <br>
    </center>
</body>

</html>
