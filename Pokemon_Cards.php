<?php
// This block allows our program to access the MySQL database.
// Stores your login information in PHP variables
require_once '../login.php';
    // Accesses the login information to connect to the MySQL server using your credentials and database
$dbserver = new mysqli($host,$username,$password,$dbname);
// This provides the error message that will appear if your credentials or database are invalid
if (!$dbserver) die("Unable to connect to MySQL: " . mysql_error());
mysqli_select_db ( $dbserver , "Pokemon_Cards")
	or die("Unable to select database: " . mysql_error());

echo <<<_FRED
<html>
    <head>
        <meta charset="utf-8">
        <title>Pokemon Cards</title>
        <h1>Pokemon Cards</h1>
    </head>
    <link href="Pokemon_Cards.css" rel="stylesheet" type="text/css">
    <link href="Pokemon_Cards.php" rel="stylesheet" type="text/php">
    <script src="Pokemon_Cards.js"></script>

    <style>
    body {
        background-color: #000000;
    }
    </style>
    <form action="Pokemon_Cards.php" method= "post" id= "addtolist">
        <br>
        <h2>Pokemon Name</h2>
        <br>
        <input type="text" name="Name" class="center" id= "Name"/>
        <br>
        <h2>Type</h2>
        <br>
        <input type="text" name="Type" class="center" id= "Type"/>
        <br>
        <h2>Move 1</h2>
        <br>
        <input type="text" name="Move1" class="center" id= "Move1"/>
        <br>
        <h2>Move 2</h2>
        <br>
        <input type="text" name="Move2" class="center" id= "Move2"/>
        <br>
    
    <input name = 'create' type= "submit" value= 'Add'>
    <input name= 'delete' type= "submit" value= 'Delete'>
    <input name= 'edit' type= "submit" value= 'Edit'>
    <input name= 'details' type= "submit" value= 'Details'>
    <input script src="Pokemon_Cards.js" name= 'dismiss' type= "submit" value= 'Dismiss'>
</form>
</html>
_FRED;

$name = $_POST["Name"];
$type = $_POST["Type"];
$move1 = $_POST["Move1"];
$move2 = $_POST["Move2"];

if ($_POST['create']){
$sql = "INSERT INTO Cards VALUES ('$name', '$type', '$move1', '$move2')";
if(mysqli_query( $dbserver, $sql)){
     echo "<span style='color:#F00;text-align:center;'>Your entry has been added to the list!";
    } 
    else{
    echo "<span style='color:#F00;text-align:center;'>ERROR: Could not able to execute $sql. " . mysqli_error($dbserver);
    }
}

elseif ($_POST['delete']){
$sql= "DELETE FROM Cards WHERE Name = '$name' or Type='$type' or Move1 = '$move1' or Move2 = '$move2' ";

if(mysqli_query( $dbserver, $sql)){
      echo "<span style='color:#F00;text-align:center;'>Information has been deleted from the list.";
    } 
    else{
    echo "<span style='color:#F00;text-align:center;'>ERROR: Could not able to execute $sql. " . mysqli_error($dbserver);
    }
}

elseif ($_POST['edit']){
    $sql= "UPDATE Cards SET Type='$type', Move1= '$move1', Move2='$move2' WHERE Name='$name'";
    if(mysqli_query( $dbserver, $sql)){
        echo "<span style='color:#F00;text-align:center;'>Information has been updated!";
        } 
        else{
     echo "<span style='color:#F00;text-align:center;'>ERROR: Could not able to execute $sql. " . mysqli_error($dbserver);
     }
    }

elseif ($_POST['details']){
$sql= "SELECT * FROM Cards";
$result= mysqli_query($dbserver, $sql);
    if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<span style='color:#F00;text-align:center;'>Pokemon: " . $row["Name"] . "-" . $row["Type"]. "-" . $row["Move1"]. "-" . $row["Move2"]. "<br>";
    }
} else {
    echo "<span style='color:#F00;text-align:center;'>0 results";
}
}

?>