<?php
require "connect.php";

if (!$con) {
    die("Connection error: " . mysqli_connect_error());
}

$name = mysqli_real_escape_string($con, $_POST['name']);
$email = mysqli_real_escape_string($con, $_POST['email']);
$password = mysqli_real_escape_string($con, $_POST['password']);

$query = "UPDATE `users` SET `name`='$name', `password`='$password' WHERE `email`='$email'";

$exe = mysqli_query($con, $query);
$arr = [];

if ($exe) {
    $arr["success"] = "true";
} else {
    $arr["success"] = "false";
}

print(json_encode($arr));
?>
