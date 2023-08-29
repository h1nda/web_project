<?php
session_start();
require_once "db_handler.php";
$response = [];
$qid = $_POST['qid'];

$updateStatusQuery = "DELETE FROM queue_info WHERE id = ?";
$updateStatusStmt = mysqli_stmt_init($conn);

if (mysqli_stmt_prepare($updateStatusStmt, $updateStatusQuery)) {
    mysqli_stmt_bind_param($updateStatusStmt, "s", $qid);
    mysqli_stmt_execute($updateStatusStmt);
    mysqli_stmt_close($updateStatusStmt);
}

// Return a JSON response indicating success
header("Content-Type: application/json");
echo json_encode(["message" => "Entries removed and status updated"]);