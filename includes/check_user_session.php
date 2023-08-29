<?php 
session_start();
$sid = $_SESSION['session_id'];
require_once "db_handler.php";

$response = [];
$stmt = $conn->prepare("SELECT * FROM queue_waiting WHERE session_id = ?;");
$stmt->execute([$sid]);
$result = $stmt->get_result();
if (!$row = $result->fetch_assoc()) {
        session_destroy();
        header("location: login.php?error=kickedout");
        $response["message"] = "Session expired and destroyed";
        exit;
} else
{
    header("location: login.php?error=kickedout");
    $response["message"] = "Valid session";
    exit;
}