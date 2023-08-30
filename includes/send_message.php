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
$text = htmlentities($_POST['text'], ENT_QUOTES, "UTF-8");

if (isset($_SESSION["session_id"])) { #student
    $sid = $_SESSION["session_id"];
    $private = $_POST['private'];
    $stmt = $conn->prepare("INSERT INTO messages (qid, uid, sender_status, text, sid, private) VALUES (?, ?, ?, ?, ?, ?);");
    $stmt->execute([$qid, $uid, $senderStatus, $text, $sid, $private]);
} else {
    $stmt = $conn->prepare("INSERT INTO messages (qid, uid, sender_status, text) VALUES (?, ?, ?, ?);");
    $stmt->execute([$qid, $uid, $senderStatus, $text]);
}

header('Content-Type: application/json');
echo json_encode(['message' => 'Message sent successfully']);
exit;
