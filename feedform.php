<?php
include("configASL.php");
session_start();

// Check if the required session variables are set
if (!isset($_SESSION['selected_roll'], $_SESSION['selected_year'], $_SESSION['selected_sem'], $_SESSION['selected_faculty_name'], $_SESSION['subjects_array'])) {
    header("location:index.php");
    exit;
}

// Retrieve values from session
$selected_roll = $_SESSION['selected_roll'];
$selected_year = $_SESSION['selected_year'];
$selected_sem = $_SESSION['selected_sem'];
$selected_faculty_name = $_SESSION['selected_faculty_name'];
$subjects_array = $_SESSION['subjects_array'];

// Check and set session variables based on POST data
if (isset($_POST['subject'])) {
    $_SESSION['selected_subject'] = $_POST['subject'];
    $selected_subject = $_POST['subject'];
}


?>

<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: rgba(196,196,196,1);
background: -moz-linear-gradient(left, rgba(196,196,196,1) 0%, rgba(191,191,191,1) 44%, rgba(222,220,218,1) 100%);
background: -webkit-gradient(left top, right top, color-stop(0%, rgba(196,196,196,1)), color-stop(44%, rgba(191,191,191,1)), color-stop(100%, rgba(222,220,218,1)));
background: -webkit-linear-gradient(left, rgba(196,196,196,1) 0%, rgba(191,191,191,1) 44%, rgba(222,220,218,1) 100%);
background: -o-linear-gradient(left, rgba(196,196,196,1) 0%, rgba(191,191,191,1) 44%, rgba(222,220,218,1) 100%);
background: -ms-linear-gradient(left, rgba(196,196,196,1) 0%, rgba(191,191,191,1) 44%, rgba(222,220,218,1) 100%);
background: linear-gradient(to right, rgba(196,196,196,1) 0%, rgba(191,191,191,1) 44%, rgba(222,220,218,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#c4c4c4', endColorstr='#dedcda', GradientType=1 );
        }

        #content
        {

            width:500px;
            height:auto;
            background-color:transparent;
            border:5px solid rgba(107,107,107,1.00);
            border-radius:2px;
            margin-left:auto;
            margin-right:auto;
        }
        .container {
            width: 60%;
            margin: 0 auto;
        }
        .SubHead
        {
            font-family:"Segoe UI";
            color:rgba(207,103,0,1.00);
            font-size:18px;
            font-weight:bold;
        }

        label
        {
            font-family:"Segoe UI";
            color:rgba(55,55,55,1.00);
            font-size:16px;
            display: inline-block;
            margin-bottom: 5px;
            cursor: pointer;
            transition: all 0.3s ease; 
        }
        
        label:hover {
            background-color: #f0f0f0; 
        }

        input[type="radio"]:checked + label {
            background-color: #e0e0e0; 
        }

        .step {
            display: none;
        }

        .step:first-child {
            display: block;
        }

        button {
            margin-top: 10px;
            padding: 8px 16px;
            font-family:"Trebuchet MS";
            font-size:16px;
            background-color:transparent;
            color:rgba(41,41,41,1.00);
            padding:2px;
            border:1px solid rgba(107,107,107,1.00);
            cursor:pointer;

        }
        button.prevBtn {
            margin-right: 10px;
        }
        button.nextBtn:hover {
            background-color: rgba(63, 63, 63, 1.00);
            color: black;
            border-color: rgba(255, 255, 255, 1.00);
        }
        button.prevBtn:hover {
            background-color: rgba(63, 63, 63, 1.00);
            color: black;
            border-color: rgba(255, 255, 255, 1.00);
        }
    
    </style>
    <title>Feedback Form</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script>
        function nextStep(step) {
            // Check if any radio button in the current step is checked
            var radios = document.querySelectorAll('.step:nth-child(' + step + ') input[type="radio"]:checked');
            if (radios.length === 0) {
                alert('Please select one option of the question before proceeding.');
                return;
            }

            document.getElementsByClassName('step')[step - 1].style.display = 'none';
            document.getElementsByClassName('step')[step].style.display = 'block';
        }

        function prevStep(step) {
            document.getElementsByClassName('step')[step - 1].style.display = 'none';
            document.getElementsByClassName('step')[step - 2].style.display = 'block';
        }
    </script>
</head>
<body>
    <br>
    <br>
        <input type="hidden" name="roll" value="<?php echo $selected_roll; ?>" />
        <input type="hidden" name="year" value="<?php echo $selected_year; ?>" />
        <input type="hidden" name="sem" value="<?php echo $selected_sem; ?>" />
        <input type="hidden" name="faculty_name" value="<?php echo $selected_faculty_name; ?>" />
        <input type="hidden" name="subject" value="<?php echo $selected_subject; ?>" />
            
    <br>
    <br>
    <div id="content" align="center">
        <br>
        <form id="feedbackForm" action="responce.php" method="post">

            <div class="step">
                <h2></h2>
                <span class="SubHead">1. Has a Teacher covered entire Syllabus as prescribe by University/Collage/Board?</span>
                    </br>
                    </br>
                <label><input type="radio" name="q1" value="1"> Very Poor</label>
                <label><input type="radio" name="q1" value="2"> Poor</label>
                <label><input type="radio" name="q1" value="3"> Average</label>
                <label><input type="radio" name="q1" value="4"> Good</label>
                <label><input type="radio" name="q1" value="5"> Excellent</label>
                    </br>
                    <input type="button" onClick="window.location='feedstep3.php'" value="BACK">
                <button type="button" class="nextBtn" onclick="nextStep(1)">Next</button>
            </div>

            <div class="step">
                <h2></h2>
                <span class="SubHead">2. Has a Teacher covered relevant topics beyond syllabus?</span>
                    </br>
                    </br>
                <label><input type="radio" name="q2" value="1"> Very Poor</label>
                <label><input type="radio" name="q2" value="2"> Poor</label>
                <label><input type="radio" name="q2" value="3"> Average</label>
                <label><input type="radio" name="q2" value="4"> Good</label>
                <label><input type="radio" name="q2" value="5"> Excellent</label>
                    </br>
                <button type="button" class="prevBtn" onclick="prevStep(2)">Back</button>
                <button type="button" class="nextBtn" onclick="nextStep(2)">Next</button>
            </div>

            <div class="step">
            <h2></h2>
                <span class="SubHead">3. Effectiveness of Teacher in terms of: </br>a. Technical Content/Course Content </span>
                    </br>
                    </br>
                <label><input type="radio" name="q3" value="1"> Very Poor</label>
                <label><input type="radio" name="q3" value="2"> Poor</label>
                <label><input type="radio" name="q3" value="3"> Average</label>
                <label><input type="radio" name="q3" value="4"> Good</label>
                <label><input type="radio" name="q3" value="5"> Excellent</label>
                    </br>
                <button type="button" class="prevBtn" onclick="prevStep(3)">Back</button>
                <button type="button" class="nextBtn" onclick="nextStep(3)">Next</button>
            </div>

            <div class="step">
                <h2></h2>
                               <span class="SubHead">b. Communication Skill</span>
                    </br>
                    </br>
                <label><input type="radio" name="q4" value="1"> Very Poor</label>
                <label><input type="radio" name="q4" value="2"> Poor</label>
                <label><input type="radio" name="q4" value="3"> Average</label>
                <label><input type="radio" name="q4" value="4"> Good</label>
                <label><input type="radio" name="q4" value="5"> Excellent</label>
                    </br>
                <button type="button" class="prevBtn" onclick="prevStep(4)">Back</button>
                <button type="button" class="nextBtn" onclick="nextStep(4)">Next</button>
            </div>

            <div class="step">
                <h2></h2>
                               <span class="SubHead">c. Use of Teaching Aids</span>
                    </br>
                    </br>
                <label><input type="radio" name="q5" value="1"> Very Poor</label>
                <label><input type="radio" name="q5" value="2"> Poor</label>
                <label><input type="radio" name="q5" value="3"> Average</label>
                <label><input type="radio" name="q5" value="4"> Good</label>
                <label><input type="radio" name="q5" value="5"> Excellent</label>
                    </br>
                <button type="button" class="prevBtn" onclick="prevStep(5)">Back</button>
                <button type="button" class="nextBtn" onclick="nextStep(5)">Next</button>
            </div>

            <div class="step">
            <h2></h2>
                               <span class="SubHead">4. Base on which contents were covered.</span>
                    </br>
                    </br>
                <label><input type="radio" name="q6" value="1"> Very Poor</label>
                <label><input type="radio" name="q6" value="2"> Poor</label>
                <label><input type="radio" name="q6" value="3"> Average</label>
                <label><input type="radio" name="q6" value="4"> Good</label>
                <label><input type="radio" name="q6" value="5"> Excellent</label>
                    </br>
                <button type="button" class="prevBtn" onclick="prevStep(6)">Back</button>
                <button type="button" class="nextBtn" onclick="nextStep(6)">Next</button>
            </div>

            <div class="step">
            <h2></h2>
                               <span class="SubHead">5. Motivation and Inspiration for Students to learn.</span>
                    </br>
                    </br>
                <label><input type="radio" name="q7" value="1"> Very Poor</label>
                <label><input type="radio" name="q7" value="2"> Poor</label>
                <label><input type="radio" name="q7" value="3"> Average</label>
                <label><input type="radio" name="q7" value="4"> Good</label>
                <label><input type="radio" name="q7" value="5"> Excellent</label>
                    </br>
                <button type="button" class="prevBtn" onclick="prevStep(7)">Back</button>
                <button type="button" class="nextBtn" onclick="nextStep(7)">Next</button>
            </div>

            <div class="step">
            <h2></h2>
                               <span class="SubHead">6. Support for Development of Students to Learn <br>i) Practical Demonstration</span>
                    </br>
                    </br>
                <label><input type="radio" name="q8" value="1"> Very Poor</label>
                <label><input type="radio" name="q8" value="2"> Poor</label>
                <label><input type="radio" name="q8" value="3"> Average</label>
                <label><input type="radio" name="q8" value="4"> Good</label>
                <label><input type="radio" name="q8" value="5"> Excellent</label>
                    </br>
                <button type="button" class="prevBtn" onclick="prevStep(8)">Back</button>
                <button type="button" class="nextBtn" onclick="nextStep(8)">Next</button>
            </div>

            <div class="step">
                <h2></h2>
                               <span class="SubHead">ii) Hands on Training</span>
                    </br>
                    </br>
                <label><input type="radio" name="q9" value="1"> Very Poor</label>
                <label><input type="radio" name="q9" value="2"> Poor</label>
                <label><input type="radio" name="q9" value="3"> Average</label>
                <label><input type="radio" name="q9" value="4"> Good</label>
                <label><input type="radio" name="q9" value="5"> Excellent</label>
                    </br>
                <button type="button" class="prevBtn" onclick="prevStep(9)">Back</button>
                <button type="button" class="nextBtn" onclick="nextStep(9)">Next</button>
            </div>

            <div class="step">
            <h2></h2>
                                <span class="SubHead">7. Clarity of Expectations of Students</span>
                    </br>
                    </br>
                <label><input type="radio" name="q10" value="1"> Very Poor</label>
                <label><input type="radio" name="q10" value="2"> Poor</label>
                <label><input type="radio" name="q10" value="3"> Average</label>
                <label><input type="radio" name="q10" value="4"> Good</label>
                <label><input type="radio" name="q10" value="5"> Excellent</label>
                    </br>
                <button type="button" class="prevBtn" onclick="prevStep(10)">Back</button>
                <button type="button" class="nextBtn" onclick="nextStep(10)">Next</button>
            </div>

            <div class="step">
            <h2></h2>
                                <span class="SubHead">8. Student Feedback provided on Students Progress</span>
                    </br>
                    </br>
                <label><input type="radio" name="q11" value="1"> Very Poor</label>
                <label><input type="radio" name="q11" value="2"> Poor</label>
                <label><input type="radio" name="q11" value="3"> Average</label>
                <label><input type="radio" name="q11" value="4"> Good</label>
                <label><input type="radio" name="q11" value="5"> Excellent</label>
                    </br>
                <button type="button" class="prevBtn" onclick="prevStep(11)">Back</button>
                <button type="button" class="nextBtn" onclick="nextStep(11)">Next</button>
            </div>

            <div class="step">
            <h2></h2>
                                <span class="SubHead">9. Willingness to offer help and advice to Students</span>
                    </br>
                    </br>
                <label><input type="radio" name="q12" value="1"> Very Poor</label>
                <label><input type="radio" name="q12" value="2"> Poor</label>
                <label><input type="radio" name="q12" value="3"> Average</label>
                <label><input type="radio" name="q12" value="4"> Good</label>
                <label><input type="radio" name="q12" value="5"> Excellent</label>
                    </br>
                <button type="button" class="prevBtn" onclick="prevStep(12)">Back</button>
                <button type="submit" class="nextBtn">Submit</button>
            </div>
            
        </form>
    </br>
    </div>

<!-- <script>
        function nextStep(step) {
            // Check if any radio button in the current step is checked
            var radios = document.querySelectorAll('.step:nth-child(' + step + ') input[type="radio"]:checked');
            if (radios.length === 0) {
                alert('Please select one option of the question before proceeding.');
                return;
            }

            document.getElementsByClassName('step')[step - 1].style.display = 'none';
            document.getElementsByClassName('step')[step].style.display = 'block';
        }

        function prevStep(step) {
            document.getElementsByClassName('step')[step - 1].style.display = 'none';
            document.getElementsByClassName('step')[step - 2].style.display = 'block';
        }
    </script> -->
</body>
</html>
