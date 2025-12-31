<?php
session_start();
$al = mysqli_connect('localhost','root','','ffs');

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if(isset($_POST['save_excel_data'])){
    $fileName = $_FILES['import_file']['name'];
    $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);

    $allowed_ext = ['xls', 'csv', 'xlsx'];

    if(in_array($file_ext,$allowed_ext))
    {
        $inputFileNamePath = $_FILES['import_file']['tmp_name'];
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileNamePath);
        $data = $spreadsheet->getActiveSheet()->toArray();

        foreach($data as $row){
            $name = $row['0'];
            $email = $row['1'];
            $year = $row['2'];
            $roll = $row['3'];

            $studentQuery = "INSERT INTO student(name, email, year, roll) VALUES ('$name', '$email', '$year', '$roll')";
            $result = mysqli_query($al, $studentQuery);
            $msg = true;

        }
        if(isset($msg)){
            $_SESSION['message'] = "Successfully Imported";
            header('Location: manageStudent.php');
            exit(0);
        }
        else{
            $_SESSION['message'] = "Not Imported";
            header('Location: manageStudent.php');
            exit(0);
        }
    }
    else{
        $_SESSION['message'] = "Invalid File";
        header('Location: manageStudent.php');
        exit(0);
    }
}
?>