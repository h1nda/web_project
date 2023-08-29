<?php
session_start();
require_once "db_handler.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
$qid = $_POST['qid'];

$stmt = $conn->prepare("DELETE FROM queue_info WHERE id = ?");
$stmt->execute([$sid]);

header("Content-Type: application/json");
echo json_encode(["message" => "Entries removed and status updated"]);
exit; 
} else {
    header("Content-Type: application/json");
    echo json_encode(["error" => "No POST request"]);
    exit; 
}