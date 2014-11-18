<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <title>Create Class</title>
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
            <li><a href="menu.html">Main Menu</a></li>
            <li><a href="import.html">Import Students</a></li>
            <li class="active"><a href="createclass.php">Create Class</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
            <li><a href="login.html"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
          </ul>
        </div>
      </div>
    </nav>
    <div class="container">
        <h1>Create Class</h1>
        <form action="addstudents.php" method="post" enctype="multipart/form-data" role="form" class="form">
            <div class="form-group">
                <label for="classID">Class ID</label>
                <input type="text" name="classID" id="classID" class="form-control" required>
            </div>
            <div class="checkbox">
               <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "serversideproj";
                try {
                    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $stmt = <<<EOT
                    SELECT student_id FROM students
EOT;
                    $results = $pdo->query($stmt, PDO::FETCH_NUM);
                    while($row = $results->fetch()){
                        foreach($row as $value){
                            echo "<label>";
                            echo"<input type='checkbox' name='$value' value='$value'>$value";
                        echo "</label><br>";
                        }
                    }
                } catch(PDOException $e){
                    echo "ERROR: " . $e->getMessage();   
                }
                $pdo = null;
                ?>
            </div>
            <input type="submit" value="Add Students" name="Submit" class="btn btn-primary">
        </form>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Optional: Incorporate the Bootstrap JavaScript plugins -->
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
</body>

</html>