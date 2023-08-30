<?php
session_start();
include 'db_handler.php'; // Include your database connection script
$response = [];
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["sid"])) {
        $sid = $_POST["sid"];

        // Prepare and execute the SQL statement to check the user's entry flag
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
