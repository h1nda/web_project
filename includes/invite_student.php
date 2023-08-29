<?php
header('Content-Type: application/json; charset=utf-8');

if (!isset($_POST['qid'])) {
    echo json_encode(['error' => 'No POST request']);
    exit;
}

require_once "db_handler.php";

$qid = $_POST['qid'];
$query = "SELECT * FROM queue_waiting WHERE id = ? ORDER BY timestamp ASC LIMIT 1;";
$stmt = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmt, $query)) {
    echo json_encode(['error' => 'Statement prep failed']);
    exit;
}

mysqli_stmt_bind_param($stmt, "s", $qid);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$response = [];

// Fetch the first row (user with earliest timestamp)
if ($row = mysqli_fetch_assoc($result)) {
    $earliestUser = $row;
    $response['student_sid'] = $earliestUser['session_id'];

    // Update the 'entry' column to true for the earliest user
    $updateQuery = "UPDATE queue_waiting SET enter = 1 WHERE session_id = ?";
    $updateStmt = mysqli_stmt_init($conn);

    if (mysqli_stmt_prepare($updateStmt, $updateQuery)) {
        mysqli_stmt_bind_param($updateStmt, "s", $earliestUser['session_id']);
        mysqli_stmt_execute($updateStmt);

        // Close the update statement
        mysqli_stmt_close($updateStmt);

        $response['message'] = 'Sent invite to '. $earliestUser['session_id'];
    } else {
        $response['error'] = 'Update failed';
    }
} else {
    $response['message'] = 'No students waiting';
}
mysqli_stmt_close($stmt);

// Output the JSON response
echo json_encode($response);
exit;
?>
