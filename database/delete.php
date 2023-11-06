<?php

require "connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['id'])) {

        $id = $_POST['id'];

        mysqli_begin_transaction($con);

        $deleteRankQuery = "DELETE FROM ranks WHERE id = $id";
        $deleteUserQuery = "DELETE FROM users WHERE id NOT IN (SELECT user_id FROM ranks)";
        if (mysqli_query($con, $deleteRankQuery)) {


            if (mysqli_query($con, $deleteUserQuery)) {
                mysqli_commit($con);
                $response = array(
                    "success" => true,
                    "message" => "Record deleted successfully"
                );
                echo json_encode($response);
            } else {
                mysqli_rollback($con);
                $response = array(
                    "success" => false,
                    "message" => "Error deleting user: " . mysqli_error($con)
                );
                echo json_encode($response);
            }
        } else {
            mysqli_rollback($con);
            $response = array(
                "success" => false,
                "message" => "Error deleting record: " . mysqli_error($con)
            );
            echo json_encode($response);
        }
    } else {
        $response = array(
            "success" => false,
            "message" => "ID is required to delete a record"
        );
        echo json_encode($response);
    }
} else {

    $response = array(
        "success" => false,
        "message" => "Invalid request method"
    );
    echo json_encode($response);
}
