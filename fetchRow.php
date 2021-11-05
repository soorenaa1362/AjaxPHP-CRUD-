<?php
    include 'db.php';

    $id = $_POST['id'];
    $result = $conn->prepare("SELECT * FROM users WHERE id=?");
    $result->bindValue(1, $id);
    $result->execute();
    $user = $result->fetch(PDO::FETCH_ASSOC);

    $json = json_encode($user);
    echo $json;
?> 

    