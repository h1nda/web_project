<?php
require_once "db_handler.php";

$query = "SELECT id, queue_name, status FROM queue_info WHERE user_id=?;";
$stmt = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmt, $query)) {
    header("location: ../index.php?error=unknown");
    exit();
} else {
    mysqli_stmt_bind_param($stmt, "s", $_SESSION['id']);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $rows = '';
    while ($row = mysqli_fetch_assoc($res)) {
        $queueId = $row["id"];
        $queue_name = $row["queue_name"];
        $status = $row["status"];
        $rows .= "<tr><td>$queueId</td><td>$queue_name</td><td>$status</td><td><button class='queue-button' id='$queueId'>Begin</button></td><td><button class='remove-button' id='$queueId'>Delete</button></td></tr>";
    }
    echo $rows;
    }
