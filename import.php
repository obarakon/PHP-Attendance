<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1">
   <title>Import Students</title>
   <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span> 
                </button>
                <a class="navbar-brand" href="menu.html">PHP-Attendance</a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
                    <li><a href="menu.html">Main Menu</a>
                    </li>
                    <li><a href="import.html">Import Students</a>
                    </li>
                    <li><a href="createclass.php">Create Class</a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a>
                    </li>
                    <li><a href="login.html"><span class="glyphicon glyphicon-log-in"></span> Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>



    <?php 


    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "serversideproj";

    try{
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        $target_dir="imports/" ; 
        $target_file= $target_dir . basename($_FILES[ "importCSV"]["name"]);
        $uploadOk = 1;
        $fileType = pathinfo($target_file,PATHINFO_EXTENSION);
        // Check if file already exists
        if (file_exists($target_file)) {
            echo "<h3>Sorry, file already exists.</h3>";
            $uploadOk = 0;
        }
        // Allow certain file formats
        if($fileType != "csv" ) {
            echo "<h3>Sorry, only CSV files are allowed.</h3>";
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "<h3>Sorry, your file was not uploaded.</h3>";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["importCSV"]["tmp_name"], $target_file)) {
                echo "<h1>The file ". basename( $_FILES["importCSV"]["name"]). " has been uploaded.</h1>";
                $conn->beginTransaction();
                $row = 1;
                echo "<div class='table-responsive'><table class='table'><thead><tr><th>Student Name</th><th>Student ID</th></tr></thead><tbody>";
                if (($handle = fopen($target_file, "r")) !== FALSE) {
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        $num = count($data);
                        $row++;
                        $conn->exec("INSERT INTO students (name, student_id) VALUES ('$data[0]','$data[1]')");
                        echo "<tr>";
                        for ($c=0; $c < $num; $c++) {
                            echo "<td>" . $data[$c] . "</td>";
                        }
                        echo"</tr>";
                    }
                    fclose($handle);
                }
                echo "</tbody></table></div>";
                $conn->commit();
                echo "<h3>Added to db</h3>";
            } else {
                echo "<h3>Sorry, there was an error uploading your file.</h3>";
            }
        }
    } catch(PDOException $e){
        echo $e->getMessage();
    }
    $conn = null;
    ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Optional: Incorporate the Bootstrap JavaScript plugins -->
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>  
</body>
</html>