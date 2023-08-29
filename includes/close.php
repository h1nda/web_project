<?php
session_start();
require_once "db_handler.php";
$qid = $_POST['qid'];


$rem_stmt = $conn->prepare("DELETE FROM queue_waiting WHERE id = ?");
$rem_stmt->execute([$qid]);

$upd_stmt = $conn->prepare("UPDATE queue_info SET status = 'closed' WHERE id = ?");
$upd_stmt->execute([$qid]);

header("Content-Type: application/json");
echo json_encode(["message" => "Entries removed and status updated"]);
exit;
