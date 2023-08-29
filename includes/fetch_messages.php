<?php
session_start();
if (!isset($_POST["qid"])) {
    header("Content-Type: application/json");
    echo json_encode(["error" => "No POST request"]);
    exit;
}
if (isset($_SESSION["username"])) {
    $is_owner = 1;
} else {
    $is_owner = 0;
}
$qid = $_POST["qid"];
require_once "db_handler.php"; // Include your database connection

$stmt = $conn->prepare("SELECT * FROM messages WHERE qid = ? ORDER BY timestamp ASC");
$stmt->execute([$qid]);

$messages = [];
$res = $stmt->get_result();
while ($row = $res->fetch_assoc()) {
    $messages[] = $row;
}
header("Content-Type: application/json");
echo json_encode(["messages" => $messages, "is_owner" => $is_owner]);
exit;
    
