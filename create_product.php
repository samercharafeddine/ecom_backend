<?php
include("./connection.php");
include("./jwt_verification.php");

$decoded=decodeJWT();
if ($decoded->id_user_type == 1) {

    $name = $_POST['name'];
    $description = $_POST['description'];
    $seller_id = $_POST['seller_id'];
    $price = $_POST['price'];

   
    $sqli = $mysqli->prepare("INSERT INTO products (name, description, seller_id, price) VALUES (?, ?, ?, ?, ?)");
    $sqli->bind_param("ssdii", $name, $description, $seller_id, $price);
    if ($sqli->execute()) {
            echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => $sqli->error]);
    }
}else{
     echo json_encode('error');
}
?>