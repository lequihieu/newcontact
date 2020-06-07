
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
  <input type="text" name="name" placeholder="Fullname">
  <input type="text" name="phone" placeholder="Phone">
  <input type="text" name="email" placeholder="Email">
  <button type="sumit" name="sumit">Sumit </button>
</form>
<a href="http://localhost/list.php">
   <input type="button" value="All users" />
</a>
</html>