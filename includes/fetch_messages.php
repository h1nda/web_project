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
require_once "db_handler.php";
if ($is_owner) {
    $stmt = $conn->prepare("SELECT * FROM messages WHERE qid = ? ORDER BY timestamp ASC");
    $stmt->execute([$qid]);
} else {
    $stmt = $conn->prepare("SELECT * FROM messages WHERE qid = ? AND (private = 0 OR (private = 1 AND uid = ?)) ORDER BY timestamp ASC;");
    $stmt->execute([$qid, $_SESSION["fn"]]);
}

$messages = [];
$res = $stmt->get_result();
while ($row = $res->fetch_assoc()) {
    $messages[] = $row;
}
header("Content-Type: application/json");
echo json_encode(["messages" => $messages, "is_owner" => $is_owner]);
exit;
    
