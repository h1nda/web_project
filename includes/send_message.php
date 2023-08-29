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

$query = "INSERT INTO messages (qid, uid, sender_status, text) VALUES (?, ?, ?, ?)";
$stmt = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmt, $query)) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Database error']);
    exit();
} else {
    mysqli_stmt_bind_param($stmt, "ssss", $qid, $uid, $senderStatus, $text);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Message sent successfully']);
    exit();
}
