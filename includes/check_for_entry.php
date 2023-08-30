<?php
session_start();
include 'db_handler.php';
$response = [];
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["sid"])) {
        $sid = $_POST["sid"];
        $stmt = $conn->prepare("SELECT enter FROM queue_waiting WHERE session_id = ?;");
        $stmt->execute([$sid]);
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $response["message"] = "Successful fetch.";
            $response["enter"] = $row['enter'];
            } else {
            $response["error"] = "No row found.";
            }
} else {
    $response["error"] = "No POST method.";
}
} else {
    $response["error"] = "No POST method.";
}
header("Content-Type: application/json");
echo json_encode($response);
