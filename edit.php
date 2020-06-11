<html>
<?php

$id = $_GET['id'];
$connection = new mysqli('localhost:3306', 'root', 'Ridaica123', 'contactdb');

$sqlget = "SELECT name, phone, email from contactdb.info where id = $id";
// var_dump($connection->query($sqlget));
$rowById = $connection->query($sqlget);
$row = mysqli_fetch_assoc($rowById);
if($connection->connect_error) {
    echo 'loi ket noi';
}

    if(isset($_POST['sumit'])) {
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        // $sql = "update contactdb.info set name = '".$name."', phone = '".$phone."', email = '".$email."' where id ='".$id."'";
        $sql = "UPDATE contactdb.info set name='" . $name . "', phone='" . $phone . "', email = '" . $email . "' WHERE id = $id";
        $connection->query($sql);
        header('location: /index.php');
    }
  $connection->close();
?>
<form class="contact-form" method="post">
  <input type="text" name="name" placeholder="Fullname" value = "<?=$row['name']?>">
  <input type="text" name="phone" placeholder="Phone" value = "<?=$row['phone']?>">
  <input type="text" name="email" placeholder="Email" value = "<?=$row['email']?>">
  <button type="sumit" name="sumit">Update </button>
</form>

</html>