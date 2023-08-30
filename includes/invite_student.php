<?php
header('Content-Type: application/json; charset=utf-8');

if (!isset($_POST['qid'])) {
    echo json_encode(['error' => 'No POST request']);
    exit;
}

require_once "db_handler.php";

$qid = $_POST['qid'];
if (!isset($_POST['sid'])) {
    $stmt = $conn->prepare("SELECT * FROM queue_waiting WHERE id = ? ORDER BY timestamp ASC LIMIT 1");
    $stmt->execute([$qid]);
} else {
    $sid = $_POST['sid'];
    $stmt = $conn->prepare("SELECT * FROM queue_waiting WHERE id = ? AND session_id = ?");
    $stmt->execute([$qid, $sid]);
}

$response = [];

if ($row = $stmt->get_result()->fetch_assoc()) {
    $student = $row;
    $response['student_sid'] = $student['session_id'];

    $update_stmt = $conn->prepare("UPDATE queue_waiting SET enter = ? WHERE session_id = ?");
    $enter = isset($_POST["temporary"]) ? 2 : 1;
    $update_stmt->execute([$enter, $response['student_sid']]);
    $response['message'] = 'Sent invite to '. $student['session_id'];

} else {
    $response['message'] = 'Student not in queue or no students';
}
// Output the JSON response
echo json_encode($response);
exit;
