<?php
    $id = $_GET['id'];
    $connection = new mysqli('localhost:3306', 'root', 'Ridaica123', 'contactdb');

    if($connection->connect_error) {
        echo 'loi ket noi';
    }
    $sql = 'delete from info where id ='. $id;
    $connection->query($sql);
   // $connection->close();
    header("location: /list.php");
?>