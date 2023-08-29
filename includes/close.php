<?php
session_start();
require_once "db_handler.php"; // Include your database connection
echo "hello";
$qid = $_POST['qid'];

// Remove entries from queue_waiting table
$removeEntriesQuery = "DELETE FROM queue_waiting WHERE id = ?";
$removeEntriesStmt = mysqli_stmt_init($conn);

if (mysqli_stmt_prepare($removeEntriesStmt, $removeEntriesQuery)) {
    mysqli_stmt_bind_param($removeEntriesStmt, "s", $qid);
    mysqli_stmt_execute($removeEntriesStmt);
    mysqli_stmt_close($removeEntriesStmt);
}

// Update status in queue_info table
$updateStatusQuery = "UPDATE queue_info SET status = 'closed' WHERE id = ?";
$updateStatusStmt = mysqli_stmt_init($conn);

if (mysqli_stmt_prepare($updateStatusStmt, $updateStatusQuery)) {
    mysqli_stmt_bind_param($updateStatusStmt, "s", $qid);
    mysqli_stmt_execute($updateStatusStmt);
    mysqli_stmt_close($updateStatusStmt);
}

// Return a JSON response indicating success
header("Content-Type: application/json");
echo json_encode(["message" => "Entries removed and status updated"]);
