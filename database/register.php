<?php
require "connect.php";

if (!$con) {
    die("Connection error: " . mysqli_connect_error());
}

$name = mysqli_real_escape_string($con, $_POST['name']);
$email = mysqli_real_escape_string($con, $_POST['email']);
$password = mysqli_real_escape_string($con, $_POST['password']);
$score = 0; 

if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
    $targetDir = "profile_images/";
    $targetFileName = $targetDir . basename($_FILES['profile_image']['name']);

    if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $targetFileName)) {
        $image_url = mysqli_real_escape_string($con, $targetFileName);
    } else {
        die("Failed to upload the profile image.");
    }
} else {
    $image_url = ""; 
}

$insertUserSQL = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
$insertUserStmt = $con->prepare($insertUserSQL);
$insertUserStmt->bind_param("sss", $name, $email, $password);


if ($insertUserStmt->execute()) {
    $user_id = $insertUserStmt->insert_id;

    
    $insertImageSQL = "INSERT INTO profile_images (user_id, caption, image_path) VALUES (?, ?, ?)";
    $insertImageStmt = $con->prepare($insertImageSQL);
    $caption = ""; 
    $insertImageStmt->bind_param("iss", $user_id, $caption, $image_url);

    if ($insertImageStmt->execute()) {
        
        $insertRankSQL = "INSERT INTO ranks (user_id, score) VALUES (?, ?)";
        $insertRankStmt = $con->prepare($insertRankSQL);
        $insertRankStmt->bind_param("ii", $user_id, $score);

        if ($insertRankStmt->execute()) {
            echo json_encode('Success');
        } else {
            die("Failed to insert rank: " . mysqli_error($con));
        }
    } else {
        die("Failed to insert profile image: " . mysqli_error($con));
    }
} else {
    die("Failed to insert user: " . mysqli_error($con));
}

function calculateUserRank($con, $score) {
    $sql = "SELECT COUNT(*) FROM ranks WHERE score > ?";
    $calculateRankStmt = $con->prepare($sql);
    $calculateRankStmt->bind_param("i", $score);

    if ($calculateRankStmt->execute()) {
        $calculateRankStmt->store_result();
        $rank = $calculateRankStmt->num_rows + 1;
        return $rank;
    } else {
        die("Rank calculation failed: " . mysqli_error($con));
    }
}
