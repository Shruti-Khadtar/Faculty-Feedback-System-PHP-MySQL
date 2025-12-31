<?php
include "configASL.php";
session_start();

if (!isset($_SESSION['username'])) {
    header("location:index.php");
    exit;
}

// Fetch roll number from the session
$selected_roll = $_SESSION['username'];

// Fetch the year of the student
$studentQuery = mysqli_query($al, "SELECT year FROM student WHERE roll = '$selected_roll'");
$student = mysqli_fetch_assoc($studentQuery);
$year = $student['year'];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Student Feedback System</title>
    <link href="style.css" rel="stylesheet" type="text/css" />
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        form {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }

        label {
            display: block;
            font-size: 16px;
            margin-bottom: 5px;
        }

        input,
        select {
            width: 90%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-bottom: 10px;
        }

        input[type="submit"]:hover {
            background-color: #000000;
        }

        .t {
            font-family: "Segoe UI";
            font-weight: bold;
        }
    </style>
    <script>
        function populateSemesters() {
            var yearSelect = document.getElementById('year');
            var semSelect = document.getElementById('sem');

            // Clear existing options
            semSelect.innerHTML = '';

            // Get the selected year
            var selectedYear = yearSelect.value;

            // Define semester options based on the selected year
            var semesterOptions = {
                'i': ['Select Sem', 'i', 'ii'],
                'ii': ['Select Sem', 'iii', 'iv'],
                'iii': ['Select Sem', 'v', 'vi'],
                'iv': ['Select Sem', 'vii', 'viii']
            };

            // Populate semester options
            for (var i = 0; i < semesterOptions[selectedYear].length; i++) {
                var option = document.createElement('option');
                option.value = semesterOptions[selectedYear][i];
                option.text = semesterOptions[selectedYear][i];
                semSelect.add(option);
            }
        }

        // Call populateSemesters on page load to set initial values
        document.addEventListener('DOMContentLoaded', function() {
            populateSemesters();
        });

        function validateForm() {
            var selectedSem = document.getElementById('sem').value;
            if (selectedSem === '' || selectedSem === 'Select Sem') {
                alert('Please select a Semester');
                return false; // Prevent form submission
            }
            return true; // Allow form submission
        }
    </script>
</head>
<body>
    <br>
    <br>
    <br>
    <div id="content" align="center">
        <br>
        <form method="post" action="feedstep2.php" onsubmit="return validateForm()">
            <div id="table"> 
                <div class="tr">
                    <div class="td">
                        <label>Roll No : </label>
                    </div>
                    <div class="td">
                        <input type="text" name="roll" value="<?php echo $selected_roll; ?>" readonly />
                    </div>
                </div>
                <div class="tr">
                    <div class="td">
                        <label>Year : </label>
                    </div>
                    <div class="td">
                        <select name="year" id="year" onchange="populateSemesters()" readonly>
                            <option value="i" <?php if ($year == 'i') echo 'selected'; ?>>i</option>
                            <option value="ii" <?php if ($year == 'ii') echo 'selected'; ?>>ii</option>
                            <option value="iii" <?php if ($year == 'iii') echo 'selected'; ?>>iii</option>
                            <option value="iv" <?php if ($year == 'iv') echo 'selected'; ?>>iv</option>
                        </select>
                        <input type="hidden" name="selected_year" value="<?php echo $year; ?>">
                    </div>
                </div>
                <div class="tr">
                    <div class="td">
                        <label>Sem : </label>
                    </div>
                    <div class="td">
                        <select name="sem" id="sem" required>
                            <!-- Semester options will be populated dynamically using JavaScript -->
                        </select>
                        <input type="hidden" name="selected_sem" value="">
                    </div>
                </div>
            </div>
            <div class="tdd">
                <input type="submit" value="NEXT" />
                <input type="button" onClick="window.location='logout.php'" value="BACK">
            </div>
        </form>
    </div>
</body>
</html>
