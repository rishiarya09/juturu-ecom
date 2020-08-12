<?php
    include 'conn.php';
    $conn = $pdo->open();
    $id = $_POST['id'];
    // $id = 1;
    $qry = $conn->prepare("SELECT * FROM products WHERE id=:id");
    $qry->execute(['id' => $id]);
    $row = $qry->fetch();
    // foreach ($row as &$value) {
    //     echo $value;
    // }
    echo $row["youtube_link"];
?>