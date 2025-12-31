<?php 
session_start();
require 'configASL.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import Excel to Mysql</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-4">
                <?php
                if(isset($_SESSION['message'])){
                    echo "<h4>".$_SESSION['message']."<h4>";
                    unset($_SESSION['message']);
                }
                ?>
                <div class="card">
                    <div class="card-header">
                        <h4>Demo to Import Excel data into database in PHP</h4>
                    </div>
                    <div class="card-body">
                    <form action="code.php" method="post" enctype="multipart/form-data">

                        <input type="file" name="imporrt_file" class="form-control"/>
                        <button class="btn btn-primary mt-3">Import</button>

                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>