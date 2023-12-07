<?php
include("connection.php");

if (isset($_POST['email'], $_POST['password'], $_POST['user_name'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user_name = $_POST['user_name'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query = $mysqli->prepare('INSERT INTO users (email, password, user_name) VALUES (?, ?, ?)');
    
    if (!$query) {
        die("Error in query preparation: " . $mysqli->error);
    }

    $query->bind_param('sss', $email, $hashed_password, $user_name);
    $query->execute();

    if ($query->error) {
        die("Error in query execution: " . $query->error);
    }

    $response = ["status" => "true"];
    echo json_encode($response);

    $query->close();
} else {
    $response = ["status" => "false", "error" => "Missing required data"];
    echo json_encode($response);
}
?>