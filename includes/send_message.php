<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['fn']) && !isset($_SESSION['username'])) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'User not logged in']);
    exit();
}

require_once "db_handler.php"; // Include your database connection

$qid = $_POST['qid'];
$uid = isset($_SESSION['fn']) ? $_SESSION['fn'] : $_SESSION['username'];
$senderStatus = isset($_SESSION['fn']) ? 'student' : 'owner';
$text = $_POST['text'];

if (isset($_SESSION["session_id"])) {
    $sid = $_SESSION["session_id"];
    $stmt = $conn->prepare("INSERT INTO messages (qid, uid, sender_status, text, sid) VALUES (?, ?, ?, ?, ?);");
    $stmt->execute([$qid, $uid, $senderStatus, $text, $sid]);
} else {
    $stmt = $conn->prepare("INSERT INTO messages (qid, uid, sender_status, text) VALUES (?, ?, ?, ?);");
    $stmt->execute([$qid, $uid, $senderStatus, $text]);
}

header('Content-Type: application/json');
echo json_encode(['message' => 'Message sent successfully']);
exit;