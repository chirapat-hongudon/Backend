<?php
require "connect.php";

$query = "SELECT users.id AS user_id, users.name AS user_name, users.email, users.password, ranks.score
          FROM ranks
          INNER JOIN users ON ranks.user_id = users.id";
$exe = mysqli_query($con, $query);

$arr = [];

while ($row = mysqli_fetch_array($exe)) {
    $arr[] = $row;
}

print(json_encode($arr));
?>
