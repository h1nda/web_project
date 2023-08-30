<?php 
$sid = $_POST['sid'];
require_once "db_handler.php";

$stmt = $conn->prepare("SELECT * FROM queue_waiting WHERE session_id = ?;");
$stmt->execute([$sid]);
$result = $stmt->get_result();
if (!$row = $result->fetch_assoc()) {
        header("Content-Type: application/json");
        echo json_encode(["message" => "Student left", "student_id" => $sid]);
        exit;
    } else {
        header("Content-Type: application/json");
        echo json_encode(["message" => "Student has not clicked link"]);
        exit;
    }

header("Content-Type: application/json");
echo json_encode(["error" => "Something went wrong"]);
exit;