<?php
include 'conn.php';
$conn = $pdo->open();
$email = $_POST['email'];
// $email = 'rishiarya09@gmail.com';
// echo $email;
// $q = "SELECT * from users";
// $qry = mysqli_query($conn,"SELECT * from `users`");        
$qry = $conn->prepare("SELECT COUNT(*) AS numrows FROM subscription WHERE email = :email");
$qry->execute(['email' => $email]);
$row = $qry->fetch();
// $row = mysqli_num_rows($qry);
// foreach($row as $result) {
    // echo $result;
// }
echo $row['numrows']
// if (!$qry)
// {
// echo("Error description: " . mysqli_error($conn));
// }
// echo $row
?>

<?php 
// require 'includes/conn.php';
// $qry = mysqli_query($con,"SELECT * from `admin` WHERE `email` = '".$_POST['email']."'");
// $row = mysqli_num_rows($qry);
// echo $row;
// ?>