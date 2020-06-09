<!DOCTYPE html>
<html>
<head>
  <title></title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>


<?php

  $connection = new mysqli('localhost:3306', 'root', 'Ridaica123', 'contactdb');
  
  if($connection->connect_error) {
    echo 'loi ket noi';
  }
  $sql = 'insert into info(name, phone, email) value(?, ?, ?)';
  $statement = $connection->prepare($sql);

    if(isset($_POST['submit'])) {
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $statement->bind_param('sss', $name, $phone, $email);
        $statement->execute();     
    } 
  
    if(isset($_POST['deleteById'])) {
      $id = $_POST["id"];
      $sql = 'delete from info where id =' . $id;
      if($connection->query($sql)) {
        echo '<script type="text/javascript">alert("Delete successful")</script>';
      };
    }

    if(isset($_POST['updateById'])) {
      $idUpdate = $_POST["id"];
      $sqlget = "SELECT name, phone, email from contactdb.info where id = $idUpdate";
      $rowById = $connection->query($sqlget);
      $row = mysqli_fetch_assoc($rowById);

    }

    if(isset($_POST['update'])) {
      $name = $_POST['name'];
      $phone = $_POST['phone'];
      $email = $_POST['email'];
      $id = $_POST['id'];

      $sqlUpdate = "UPDATE contactdb.info set name='" . $name . "', phone='" . $phone . "', email = '" . $email . "' WHERE id = $id";
      $connection->query($sqlUpdate);
                 
    }
?>
<div class="container">
  <div class="row">
    <div class="col-3">
                <div>
                  <form class="contact-form" method="post">
                      <div class="form-group">
                        <input class="form-control" type="text" name="name" placeholder="Fullname" value = "<?=$row['name']?>" pattern="([A-Za-z\s]{1,30})">
                      </div>
                      <div class="form-group">
                        <input class="form-control" type="text" name="phone" placeholder="Phone" value = "<?=$row['phone']?>" pattern="^0(1\d{9}|9\d{8})$">
                      </div>
                      <div class="form-group">
                        <input class="form-control" type="text" name="email" placeholder="Email" value = "<?=$row['email']?>" pattern="^[a-z][a-z0-9_\.]{5,32}@[a-z0-9]{2,}(\.[a-z0-9]{2,4}){1,2}$">
                      </div>  
                        <input type="hidden" name="id" value = "<?=$idUpdate?>">
                        <button class="btn btn-primary" type="submit" name="submit" onclick="return confirm('Want to Submit?')">Submit </button>
                        <button class="btn btn-primary" type="submit" name="update" onclick="return confirm('Want to Update?')">Update</buttom>
                  </form>
                </div>
    </div>

    <div class="col-9">
                  <div>
                    <form  method="post">
                      <input class="form-control" type="text" name="textSearch" placeholder="Text Search">
                      <button class="btn btn-primary" type="submit" name="searchList">Search </button>
                    </form>
                  </div>

                  <div>
                      <?php
                          if(!isset($_POST['searchList'])) {
                          $getAllUsers = 'SELECT * FROM contactdb.info';
                          $result = mysqli_query($connection, $getAllUsers);
                          if($result->num_rows > 0) {
                            echo '<table class="table">
                            <thead>
                              <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Name</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Email</th>
                              </tr>
                            </thead>
                            <tbody>';

                            while($row = $result->fetch_assoc()) {
                              echo '<tr>
                              <th scope="row">'.$row["id"].'</th>
                              <td>'.$row["name"].'</td>
                              <td>'.$row["phone"].'</td>
                              <td>'.$row["email"].'</td>
                              <td>';
                              echo '<form method="post">';
                              echo '<input type="hidden" name="id" value='.$row["id"] . '>';
                              echo '<input class="btn btn-primary" type="submit" name="updateById" value="Update"'.'onclick="return confirm('."'Want to Update?'".')"> ';
                              echo '<input class="btn btn-primary" type="submit" name="deleteById" value="Delete"'.'onclick="return confirm('."'Want to Delete?'".')">';
                              // onclick="return confirm('Want to Submit?')
                            echo '</form>';
                            echo '</td>
                            </tr>'; 
                            }
                            echo '</tbody>
                            </table>';
                          } else {
                            echo "no data";
                        }
                      }
                      ?>
                  </div>



                    <div>
                      <?php
                        if(isset($_POST['searchList'])) {
                          $textSearch = $_POST['textSearch'];
                          $sqlSearch = 'select * from contactdb.info where CONCAT_WS('. "''" . ', name, phone, email) LIKE ' . "'" . "%$textSearch%" . "'";
                          $result = mysqli_query($connection, $sqlSearch);
                          if($result->num_rows > 0) {
                            echo '<table class="table">
                            <thead>
                              <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Name</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Email</th>
                                
                              </tr>
                            </thead>
                            <tbody>';

                            while($row = $result->fetch_assoc()) {
                                  echo '<tr>
                                  <th scope="row">'.$row["id"].'</th>
                                  <td>'.$row["name"].'</td>
                                  <td>'.$row["phone"].'</td>
                                  <td>'.$row["email"].'</td>
                                  <td>';
                                  echo '<form method="post">';
                                  echo '<input type="hidden" name="id" value='.$row["id"] . '>';
                                  echo '<input class="btn btn-primary" type="submit" name="updateById" value="Update"'.'onclick="return confirm('."'Want to Update?'".')"> ';
                                  echo '<input class="btn btn-primary" type="submit" name="deleteById" value="Delete"'.'onclick="return confirm('."'Want to Delete?'".')">';
                                  // onclick="return confirm('Want to Submit?')
                                echo '</form>';
                                echo '</td>
                                </tr>'; 
                            }
                            echo '</tbody>
                            </table>';
                          } else {
                            echo "no data";
                          }
                        }  
                      ?>
                    </div>
    </div>   
  </div>                  

</div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>