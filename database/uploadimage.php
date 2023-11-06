<?php
require "connect.php";


if (isset($_POST["caption"]) && isset($_POST["data"]) && isset($_POST["name"]) && isset($_POST["user_id"])) {
    $cap = $_POST["caption"];
    $data = $_POST["data"];
    $name = $_POST["name"];
    $user_id = $_POST["user_id"];
} else {
    
    $response = ["success" => "false", "message" => "Incomplete data"];
    print(json_encode($response));
    exit;
}
$path = "upload/$name";

$insertImageSQL = "INSERT INTO `profile_images`(`user_id`, `caption`, `image_path`) VALUES (?, ?, ?)";

$response = [];
if ($stmt = mysqli_prepare($con, $insertImageSQL)) {
    
    mysqli_stmt_bind_param($stmt, "iss", $user_id, $cap, $path);
    if (mysqli_stmt_execute($stmt)) {
        
        file_put_contents($path, base64_decode($data));

        $response["success"] = "true";
    } else {
        $response["success"] = "false";
        $response["message"] = "Database insertion failed: " . mysqli_error($con);
    }
} else {
    $response["success"] = "false";
    $response["message"] = "Prepared statement error";
}

print(json_encode($response));
