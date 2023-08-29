<?php
if (!isset($_POST["qid"])) {
    header("Content-Type: application/json");
    echo json_encode(["error" => "No POST request"]);
    exit;
}
$qid = $_POST["qid"];
require_once "db_handler.php"; // Include your database connection
$query = "SELECT * FROM messages WHERE qid = ? ORDER BY timestamp ASC";
$stmt = mysqli_stmt_init($conn);
if (mysqli_stmt_prepare($stmt, $query)) {
    mysqli_stmt_bind_param($stmt, "s", $qid);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    $messages = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $messages[] = $row;
    }
    
    mysqli_stmt_close($stmt);
    
    header("Content-Type: application/json");
    echo json_encode($messages);
}
    
