<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
</body>

<?php

  $connection = new mysqli('localhost:3306', 'root', 'Ridaica123', 'contactdb');

  if($connection->connect_error) {
    echo 'loi ket noi';
  }
  $sql = 'insert into info(name, phone, email) value(?, ?, ?)';
  $statement = $connection->prepare($sql);

    if(isset($_POST['sumit'])) {
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $statement->bind_param('sss', $name, $phone, $email);
        $statement->execute();        
    } 
  
    
?>


<form class="contact-form" method="post">
  <input type="text" name="name" placeholder="Fullname" value = "<?=$row['name']?>">
  <input type="text" name="phone" placeholder="Phone" value = "<?=$row['phone']?>">
  <input type="email" name="email" placeholder="Email" value = "<?=$row['email']?>">
  <button type="sumit" name="sumit">Sumit </button>
  <button type="sumit" name="update">Update</buttom>
</form>

<form method="get">
    <button type="sumit" name="getAllUsers">Get All Users</button>
</form>

<div>
    <?php
      if(isset($_GET['getAllUsers'])) {
        $getAllUsers = 'SELECT * FROM contactdb.info';
        $result = mysqli_query($connection, $getAllUsers);
        if($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
              echo "id: " . $row["id"]. " - Name: ". $row["name"] . " - Phone: " . $row["phone"] . " - Email: " . $row["email"];
              echo '<form method="get">';
              echo '<a href = "/edit.php?id=' . $row["id"]. '" type="sumit" name="sumit">Update </a>';
              echo '<a href = "/delete.php?id=' . $row["id"]. '"type="sumit" name="sumit">Delete </a>' . '<br>';
          }
        } else {
          echo "no data";
      }
      }
    ?>
</div>

<form  method="post">
    <input type="text" name="textSearch" placeholder="Text Search">
    <button type="sumit" name="searchList">Search </button>
</form>

<div>
    <?php
      if(isset($_POST['searchList'])) {
        $textSearch = $_POST['textSearch'];
        $sqlSearch = 'select * from contactdb.info where CONCAT_WS('. "''" . ', name, phone, email) LIKE ' . "'" . "%$textSearch%" . "'";
        $result = mysqli_query($connection, $sqlSearch);
        if($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
              echo "id: " . $row["id"]. " - Name: ". $row["name"] . " - Phone: " . $row["phone"] . " - Email: " . $row["email"];
              echo '<a href = "/edit.php?id=' . $row["id"]. '" type="sumit" name="sumit">Update </a>';
              echo '<a href = "/delete.php?id=' . $row["id"]. '"type="sumit" name="sumit">Delete </a>' . '<br>';
          }
        } else {
          echo "no data";
        }
      }  
    ?>
</div>

</html>