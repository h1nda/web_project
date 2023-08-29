<?php
require_once "db_handler.php";

$stmt = $conn->prepare("SELECT id, queue_name, status FROM queue_info WHERE user_id=?;");
$stmt->execute($_SESSION['id']);
$result = $stmt->get_result();

$rows = '';
while ($row = $result->fetch_assoc()) {
    $queueId = $row["id"];
    $queue_name = $row["queue_name"];
    $status = $row["status"];
    $rows .= "<tr><td>$queueId</td><td>$queue_name</td><td>$status</td><td><button class='queue-button' id='$queueId'>Begin</button></td><td><button class='remove-button' id='$queueId'>Delete</button></td></tr>";
}

echo $rows;
