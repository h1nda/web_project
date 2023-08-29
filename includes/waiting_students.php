<?php
include 'db_handler.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $qid = $_POST["qid"];
    $stmt = $conn->prepare("SELECT COUNT(*) AS num_students FROM queue_waiting WHERE id = ?");
    $stmt->execute([$qid]);
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