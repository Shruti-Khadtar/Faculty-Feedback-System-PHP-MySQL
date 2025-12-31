<?php
include("configASL.php");
session_start();

if (!isset($_SESSION['username'])) {
    header("location:index.php");
}

$id = $_SESSION['username'];
$x = mysqli_query($al, "SELECT * FROM alogin WHERE id='$id'");
$y = mysqli_fetch_array($x);
$name = $y['name'];

// Handle form submission
if (!empty($_POST)) {
    $name = $_POST['name'];
    $year = $_POST['year'];
    $sem = $_POST['sem'];
    $faculty_id = uniqid();

    $subjects = array();
    for ($i = 1; $i <= 6; $i++) {
        $subjectName = 's' . $i;
        if (isset($_POST[$subjectName])) {
            $subjects[] = $_POST[$subjectName];
        }
    }

    $subjectString = implode(', ', $subjects);

    // Clear previously submitted data to avoid conflicts
    unset($_POST);

    // Execute the insert query and check for success
    $u = mysqli_query($al, "INSERT INTO faculty(faculty_id, name, year, sem, subjects) VALUES ('$faculty_id', '$name', '$year', '$sem', '$subjectString')");
    if ($u) {
        ?>
        <script type="application/javascript">
            alert('Faculty added successfully!');
        </script>
        <?php
    } else {
        echo "Error adding faculty: " . mysqli_error($al);
    }
}
?>

<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Faculty Feedback System</title>
    <link href="style.css" rel="stylesheet" type="text/css" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
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
            width: 80%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .addSubject {
            margin-top: 10px;
            cursor: pointer;
            padding: 8px;
            background-color: #000000;
            color: #fff;
            border: none;
            border-radius: 4px;
        }

        input[type="submit"]:hover {
            background-color: #000000;
        }
        .t{
            font-family:"Segoe UI";
            font-weight:bold;
        }
    </style>
</head>

<body>
    <br>
    <br>

    <div id="content" align="center">
        <br>
        <span class="SubHead">Add Faculty</span>
        <br>
        <br>
        <form method="post" action=" " id="facultyForm">
            <div id="table">
                <div class="tr">
                    <div class="td">
                        <label>Faculty : </label>
                    </div>
                    <div class="td">
                        <input type="text" name="name" size="25" required placeholder="Enter Faculty Name" />
                    </div>
                </div>
                <div class="tr">
                    <div class="td">
                        <label>Year : </label>
                    </div>
                    <div class="td">
                        <select name="year" id="yearSelect" required>
                            <option value="" disabled selected> - - Select Year - -</option>
                            <option value="i">F.Y</option>
                            <option value="ii">S.Y</option>
                            <option value="iii">T.Y</option>
                            <option value="iv">Final Year</option>
                        </select>
                    </div>
                </div>
                <div class="tr">
                    <div class="td">
                        <label>Semester : </label>
                    </div>
                    <div class="td">
                        <select name="sem" id="semSelect" required>
                            <option value="" disabled selected> - - Select Semester - -</option>
                        </select>
                    </div>
                </div>
                <div class="tr">
                    <div class="td">
                        <label>Subject 1 : </label>
                    </div>
                    <div class="td">
                        <span>
                        <input type="text" name="s1" size="25" required placeholder="Enter Subject" /><button type="button" class="addSubject">+</button>  
                        </span>
                    </div>
                </div>
            </div>
            <div class="tdd">
                <input type="submit" value="ADD FACULTY" />
            </div>
            <br>
        </form>
    </div>

    <br>
    <br>

    <div align="center">
        <span class="SubHead">Manage Faculty</span>
        <br>
        <br>
        <table border="0" cellpadding="3" cellspacing="3">
            <tr style="font-weight:bold;">
                <td class="t">Delete</td>
                <td class="t">Sr. No.</td>
                <td class="t">Name</td>
                <td class="t">Year</td>
                <td class="t">Semester</td>
                <?php for ($i = 1; $i <= 5; $i++) { ?>
                    <td class="t">Subject <?php echo $i; ?></td>
                <?php } ?>
            </tr>
            <?php
            $sr = 1;
            $h = mysqli_query($al, "SELECT * FROM faculty");
            while ($j = mysqli_fetch_array($h)) {
            ?>
                <tr>
                    <td align="center">
                        <a href="delete.php?id=<?php echo $j['faculty_id']; ?>" onClick="return confirm('Are you sure?')" style="text-decoration:none;font-size:18px;color:rgba(255,0,4,1.00);">[x]</a>
                    </td>
                    <td><?php echo $sr;
                        $sr++; ?>
                    </td>
                    <td><?php echo $j['name']; ?>
                    </td>
                    <td><?php echo $j['year']; ?></td>
                    <td><?php echo $j['sem']; ?></td>
                    <?php
                    $subjectsArray = explode(', ', $j['subjects']);
                    foreach ($subjectsArray as $subject) {
                        echo '<td>' . $subject . '</td>';
                    }
                    ?>
                </tr>
            <?php } ?>
        </table>

        <br>

        <input type="button" onClick="window.location='home.php'" value="BACK">
        <br>
        <br>
    </div>

    <br>
    <br>
    <br>

    <br>
    <br>

    <script>
        $(document).ready(function() {
            // Add options to semester based on the selected year
            $("#yearSelect").change(function() {
                var selectedYear = $(this).val();
                var semSelect = $("#semSelect");

                // Clear existing options
                semSelect.empty();

                // Add new options based on the selected year
                if (selectedYear === "i") {
                    semSelect.append('<option value="1">Semester 1</option>');
                    semSelect.append('<option value="2">Semester 2</option>');
                } else if (selectedYear === "ii") {
                    semSelect.append('<option value="3">Semester 3</option>');
                    semSelect.append('<option value="4">Semester 4</option>');
                } else if (selectedYear === "iii") {
                    semSelect.append('<option value="5">Semester 5</option>');
                    semSelect.append('<option value="6">Semester 6</option>');
                } else if (selectedYear === "iv") {
                    semSelect.append('<option value="7">Semester 7</option>');
                    semSelect.append('<option value="8">Semester 8</option>');
                }
            });

            var subjectCount = 2; // Starting from 2 as Subject 1 is already present

            $(".addSubject").click(function() {
                if (subjectCount <= 6) {
                    var subjectLabel = 'Subject ' + subjectCount + ' : ';
                    var subjectName = 's' + subjectCount;
                    var html = '<div class="tr"><div class="td"><label>' + subjectLabel + '</label></div><div class="td"><input type="text" name="' + subjectName + '" size="25" required placeholder="Enter Subject" /></div></div>';
                    $("#table").append(html);
                    subjectCount++;
                }
            });
        });
    </script>

</body>

</html>
