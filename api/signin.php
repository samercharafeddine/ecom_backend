<?php

include("./connection.php");

require __DIR__ . '/vendor/autoload.php';

use Firebase\JWT\JWT;

$email = $_POST['email'];
$password = $_POST['password'];
$query = $mysqli->prepare('select id_user,user_name,password from users where email=?');
$query->bind_param('s', $email);
$query->execute();
$query->store_result();
$num_rows = $query->num_rows;
$query->bind_result($id, $name, $id_user_type, $hashed_password);
$query->fetch();


$response = [];
if ($num_rows == 0) {
    $response['status'] = 'user not found';
    echo json_encode($response);
} else {
    if (password_verify($password, $hashed_password)) {
        $key = "your_secret";
        $payload_array = [];
        $payload_array["user_id"] = $id;
        $payload_array["name"] = $name;
        $payload_array["usertype"] = $id_user_type;
        $payload_array["exp"] = time() + 3600;
        $payload = $payload_array;
        $response['status'] = 'logged in';
        $jwt = JWT::encode($payload, $key, 'HS256');
        $response['jwt'] = $jwt;
        echo json_encode($response);
    } else {
        $response['status'] = 'wrong credentials';
        echo json_encode($response);
    }
};