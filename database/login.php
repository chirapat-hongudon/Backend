<?php
require "connect.php";

if (!$con) {
    die("Connection error: " . mysqli_connect_error());
}

$email = mysqli_real_escape_string($con, $_POST['email']);
$password = mysqli_real_escape_string($con, $_POST['password']);

$sql = "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($con, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($con));
}

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $hashed_password = $row['password'];
    $user_name = $row['name']; 

    /* if (password_verify($password, $hashed_password)) { */
    if ($password === $hashed_password) {
        $response = array('status' => 'Success', 'name' => $user_name);
        echo json_encode($response);
    } else {
        echo json_encode('Error');
    }
} else {
    echo json_encode('Error');
}
?>
