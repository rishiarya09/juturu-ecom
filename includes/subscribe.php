<?php
include 'conn.php';
$conn = $pdo->open();
$email = $_POST['email'];
// $email = 'harry@gmail.com';
$qry = $conn->prepare("INSERT INTO subscription (email) VALUES (:email)");
$qry->execute(['email'=> $email]);
setcookie("email", $email, time() + (60*60*24*7), "/");
if(!isset($_COOKIE["email"])){
    echo "cookei named" .$email . "' is not set!";
} else {
    echo "Cookie email" . $email . "' is set!<br>";
}
?>