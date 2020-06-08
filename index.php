
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
    if(isset($_POST['searchList'])) {
      $textSearch = $_POST['textSearch'];
      header("location: /search.php?q=$textSearch");
    }
    
?>


<form class="contact-form" method="post">
  <input type="text" name="name" placeholder="Fullname">
  <input type="text" name="phone" placeholder="Phone">
  <input type="text" name="email" placeholder="Email">
  <button type="sumit" name="sumit">Sumit </button>
</form>

<a href="http://localhost/list.php">
   <input type="button" value="All users" />
</a>

<form  method="post">
    <input type="text" name="textSearch" placeholder="Text Search">
    <button type="sumit" name="searchList">Search </button>
</form>

</html>