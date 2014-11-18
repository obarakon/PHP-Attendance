<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1">
   <title>Create Class</title>
   <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
</head>
<body>



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
        $className = $_POST["className"];
        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }
        // Allow certain file formats
        if($fileType != "csv" ) {
            echo "Sorry, only CSV files are allowed.";
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["importCSV"]["tmp_name"], $target_file)) {
                echo "<h1>The file ". basename( $_FILES["importCSV"]["name"]). " has been uploaded.</h1>";
                $conn->beginTransaction();
                $row = 1;
                echo "<div class='table-responsive'><table class='table'>";
                if (($handle = fopen($target_file, "r")) !== FALSE) {
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        $num = count($data);
                        $row++;
                        $conn->exec("INSERT INTO students (name, student_id) VALUES ('$data[0]','$data[1]')");
                        for ($c=0; $c < $num; $c++) {
                            echo "<td>" . $data[$c] . "</td>";
                        }
                        echo"</tr>";
                    }
                    fclose($handle);
                }
                echo "</table></div>";
                $conn->commit();
                echo "<h3>Added to db</h3>";
            } else {
                echo "Sorry, there was an error uploading your file.";
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