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
            echo "The file ". basename( $_FILES["importCSV"]["name"]). " has been uploaded.";
            $conn->beginTransaction();
            $row = 1;
            if (($handle = fopen($target_file, "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $num = count($data);
                    echo "<p>$num fields in line $row: <br /></p>\n";
                    $row++;
                    for ($c=0; $c< $num; $c++) {
                        echo $data[$c] . "<br />\n";
                        $conn->exec("INSERT INTO class (Name, ID) VALUES ('$data[0]','$data[1]')");
                    }
                }
                fclose($handle);
            }
            $conn->commit();
            echo "Added to db";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
} catch(PDOException $e){
    echo $e->getMessage();
}
$conn = null;