<?php
include("configASL.php");
session_start();

if (!isset($_SESSION['username'])) {
    header("location:index.php");
    exit;
}

$id = $_SESSION['id'];
$x = mysqli_query($al, "select * from alogin where id='$id'");
$y = mysqli_fetch_array($x);
$name = $y['name'];

// Fetch subjects for the selected year
$selectedYear = isset($_POST['year']) ? $_POST['year'] : '';

if (!empty($_POST)) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $year = $_POST['year'];
    $roll = $_POST['roll'];
    $email = $_POST['email'];

    // Handle the subjects array
    if (isset($_POST['subjects']) && is_array($_POST['subjects'])) {
        $subjects = implode(', ', $_POST['subjects']);
    } else {
        $subjects = ''; // Default value if no subjects are selected
    }

    $u = mysqli_query($al, "INSERT INTO `student`(`id`, `name`, `year`, `roll`, `email`, `subjects`) VALUES ('$id','$name','$year','$roll','$email','$subjects')");

    if ($u == true) {
        ?>
        <script type="application/javascript">
            alert('Successfully added');
        </script>
    <?php
    }
}

// Fetch subjects based on the selected year
$subjectsQuery = mysqli_query($al, "SELECT subjects FROM faculty WHERE year = '$selectedYear'");
$availableSubjects = array();

while ($subjectRow = mysqli_fetch_assoc($subjectsQuery)) {
    $availableSubjects[] = $subjectRow['subjects'];
}
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Faculty Feedback System</title>
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
</head>

<body>
    <br>
    <br>
    <br>
    <br>

    <div id="content" align="center">
        <br>
        <span class="SubHead">Add Student</span>
        <br>
        <br>
        <form method="post" action=" ">
            <div id="table">
                <div class="tr">
                    <div class="td">
                        <label>Name: </label>
                    </div>
                    <div class="td">
                        <input type="text" name="name" size="25" required placeholder="Enter Student Name" />
                    </div>
                </div>
                <div class="tr">
                    <div class="td">
                        <label>Email : </label>
                    </div>
                    <div class="td">
                        <input type="text" name="email" size="25" required placeholder="Enter Email" />
                    </div>
                </div>
                <div class="tr">
                    <div class="td">
                        <label>Roll no. : </label>
                    </div>
                    <div class="td">
                        <input type="text" name="roll" size="25" required placeholder="Enter Roll Number" />
                    </div>
                </div>
                <div class="tr">
                    <div class="td">
                        <label>Year : </label>
                    </div>
                    <select class="form-control" id="year" placeholder="Enter Year" name="year" required onchange="fetchSubjects(this.value)">
                        <option value="" disabled="" selected="">Year</option>
                        <option style="color:black" value="i">i</option>
                        <option style="color:black" value="ii">ii</option>
                        <option style="color:black" value="iii">iii</option>
                        <option style="color:black" value="iv">iv</option>
                    </select>
                </div>
                <div class="tr">
                    <div class="td">
                        <label>Subjects : </label>
                    </div>
                    <div class="td" id="subjectCheckboxDiv">
                        <table>
                            <tr>
                                
                            </tr>
                        </table><!-- Subjects checkboxes will be populated here based on the selected year -->
                    </div>
                </div>
            </div>

            <div class="tdd">
                <input type="submit" value="ADD STUDENT" />
            </div>
        </form>

            <br>
            <br>
            <span class="SubHead">Manage Student</span>
            <br>
            <br>
            <!-- Choose File <h3>Choose File</h3> Import -->
        <form action="" method="post" enctype="multipart/form-data">
            <input type="file" name="excel" required value="">
            <button type="submit" name="import">Add</button>
            <br>
            <br>
            <table border="0" cellpadding="3" cellspacing="3">
                <tr style="font-weight:bold;">
                    <td class="t">Sr. No.</td>
                    <td class="t">Name</td>
                    <td class="t">Email</td>
                    <td class="t">Year</td>
                    <td class="t">Roll No.</td>
                    <td class="t">Delete</td>

                </tr>
                <?php
                $sr = 1;
                $h = mysqli_query($al, "SELECT * FROM `student`");
                while ($j = mysqli_fetch_array($h)) {
                    ?>
                    <tr>
                        <td><?php echo $sr;
                            $sr++; ?></td>
                        <td><?php echo $j['name']; ?></td>
                        <td><?php echo $j['email']; ?></td>
                        <td><?php echo $j['year']; ?></td>
                        <td><?php echo $j['roll']; ?></td>
                        <td align="center"><a href="delete2.php?del=<?php echo $j['id']; ?>" onClick="return confirm('Are you sure?')" style="text-decoration:none;font-size:18px;color:rgba(255,0,4,1.00);">[x]</a></td>
                    </tr>
                <?php } ?>
            </table>

            <?php
                if(isset($_POST["import"])){
                    $fileName = $_FILES["excel"]["name"];
                    $fileExtension = explode('.', $fileName);
                    $fileExtension = strtolower(end($fileExtension));

                    $newFileName = date("Y.m.d") . "-" . date("h.i.sa") . "." . $fileExtension;

                    $targetDirectory = "uploads/" . $newFileName;
                    move_uploaded_file($_FILES["excel"]["tmp_name"], $targetDirectory);

                    error_reporting(0);
                    ini_set('display_errors', 0);

                    require "excelReader/excel_reader2.php";
                    require "excelReader/SpreadsheetReader.php";

                    $reader = new SpreadsheetReader($targetDirectory);
                    foreach($reader as $key => $j){
                        $name = $j[1];
                        $email = $j[2];
                        $year = $j[3];
                        $roll = $j[0];
                        mysqli_query($al, "INSERT INTO student VALUES('', 'name', 'email', 'year', 'roll')");
                    }

                    echo "
                        <script>
                        alert('Successfully Added');
                        document.location.href = '';
                        </script>
                    ";
                }
            ?>

            <br>

            <input type="button" onClick="window.location='home.php'" value="BACK">
            <br>
            <br>
        </form>
        <script type="text/javascript">
            function fetchSubjects(selectedYear) {
                // AJAX request to fetch subjects based on the selected year
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("subjectCheckboxDiv").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "fetch_subjects.php?year=" + selectedYear, true);
                xmlhttp.send();
            }
        </script>

        <br>
        <br>
        <br>

        <br>
        <br>

    </div>
</body>
</html>
