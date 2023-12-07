<?php
include("../connection.php");
include("../jwt_verification.php");

$id_product = $_POST['id_product'];
$name = $_POST['name'];
$description = $_POST['description'];
$price = $_POST['price'];
$seller_id = $_POST['seller_id'];



$decoded=decodeJWT();

if ($decoded->user_type_id == 1) {
    $sqli = $mysqli->prepare("UPDATE products SET product_name = ?, product_description = ?, product_price = ? WHERE product_id = ? AND seller_id = ?");
    $sqli->bind_param("ssdpps", $name, $description, $price, $id_product, $seller_id);
    if ($sqli->execute()) {
        
        echo json_encode("product updated succesfully");
    }else {
        echo json_encode(['error' => $sqli->error]);
    }

}
else{ echo json_encode('error');}
?>