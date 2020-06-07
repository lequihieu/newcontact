<?php
$servername = "localhost:3306";
$username = "root";
$password = "Ridaica123";
$dbname = "contactdb";

$connection = new mysqli($servername, $username, $password, $dbname);
if($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$sql = 'SELECT id, name, phone, email from info';
$result = $connection->query($sql);


if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"]. " - Name: ". $row["name"] . " - Phone: " . $row["phone"] . " - Email: " . $row["email"];
        echo '<a href = "/edit.php?id=' . $row["id"]. '" type="sumit" name="sumit">Update </a>';
        echo '<a href = "/delete.php?id=' . $row["id"]. '"type="sumit" name="sumit">Delete </a>' . '<br>';
    }
} else {
    echo "no data";
}
   // $connection->close();
?>