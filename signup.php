<?php
include("./connection.php");

$user_name = $_POST['user_name'];
$password = $_POST['password'];
$id_user_type = 0;
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$query = $mysqli->prepare('insert into users(user_name,password,id_usertype,first_name,last_name) 
values(?,?,?,?,?)');
$query->bind_param('ssiss', $user_name, $hashed_password, $id_user_type, $first_name, $last_name);
$query->execute();

$response = [];
$response["status"] = "true";

echo json_encode($response);
