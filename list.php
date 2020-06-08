<!DOCTYPE html>
<html>
    <head>
        <title>Ví dụ phân trang trong PHP và MySQL</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
<?php
$servername = "localhost:3306";
$username = "root";
$password = "Ridaica123";
$dbname = "contactdb";

$connection = new mysqli($servername, $username, $password, $dbname);
if($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$result = mysqli_query($connection, 'select count(id) as total from info');
$row = mysqli_fetch_assoc($result);
$total_records = $row['total'];

 
 $current_page = isset($_GET['page']) ? $_GET['page'] : 1;

 $limit = 10;

 
 $total_page = ceil($total_records / $limit);

 
 if ($current_page > $total_page){
     $current_page = $total_page;
 }
 else if ($current_page < 1){
     $current_page = 1;
 }


 $start = ($current_page - 1) * $limit;


 $result = mysqli_query($connection, "SELECT * FROM info LIMIT $start, $limit");


// if($result->num_rows > 0) {
//     while($row = $result->fetch_assoc()) {
//         echo "id: " . $row["id"]. " - Name: ". $row["name"] . " - Phone: " . $row["phone"] . " - Email: " . $row["email"];
//         echo '<a href = "/edit.php?id=' . $row["id"]. '" type="sumit" name="sumit">Update </a>';
//         echo '<a href = "/delete.php?id=' . $row["id"]. '"type="sumit" name="sumit">Delete </a>' . '<br>';
//     }
// } else {
//     echo "no data";
// }
   // $connection->close();
?>
        <div>
            <?php 
            
            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "id: " . $row["id"]. " - Name: ". $row["name"] . " - Phone: " . $row["phone"] . " - Email: " . $row["email"];
                    echo '<a href = "/edit.php?id=' . $row["id"]. '" type="sumit" name="sumit">Update </a>';
                    echo '<a href = "/delete.php?id=' . $row["id"]. '"type="sumit" name="sumit">Delete </a>' . '<br>';
                }
            } else {
                echo "no data";
            }
            ?>
        </div>
        <div class="pagination">
           <?php 
       
            // nếu current_page > 1 và total_page > 1 mới hiển thị nút prev
            if ($current_page > 1 && $total_page > 1){
                echo '<a href="/list.php?page='.($current_page-1).'">Prev</a> | ';
            }
 
            // Lặp khoảng giữa
            for ($i = 1; $i <= $total_page; $i++){
                // Nếu là trang hiện tại thì hiển thị thẻ span
                // ngược lại hiển thị thẻ a
                if ($i == $current_page){
                    echo '<span>'.$i.'</span> | ';
                }
                else{
                    echo '<a href="/list.php?page='.$i.'">'.$i.'</a> | ';
                }
            }
 
            // nếu current_page < $total_page và total_page > 1 mới hiển thị nút prev
            if ($current_page < $total_page && $total_page > 1){
                echo '<a href="/list.php?page='.($current_page+1).'">Next</a> | ';
            }
           ?>
        </div>
</body>
</html>