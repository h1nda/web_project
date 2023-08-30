<?php
session_start();
include 'db_handler.php';
$student_req = isset($_SESSION["session_id"]);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $qid = $_POST["qid"];
    if (!$student_req) {
        $stmt = $conn->prepare("SELECT COUNT(*) AS num_students FROM queue_waiting WHERE id = ?");
        $stmt->execute([$qid]);
    } else {
        $stmt = $conn->prepare("SELECT COUNT(*) AS num_students FROM queue_waiting WHERE id = ? AND timestamp < (SELECT timestamp FROM queue_waiting WHERE session_id = ?)");
        $stmt->execute([$qid, $_SESSION["session_id"]]);
    }
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    header("Content-Type: application/json");
    echo json_encode(["num_students" => $row["num_students"]]);
    exit;
} else {
    header("Content-Type: application/json");
    echo json_encode(["error" => "No POST request"]);
    exit;
}
