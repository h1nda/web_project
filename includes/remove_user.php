<?php
session_start();
$response = [];
if (isset($_POST["qid"]) && isset($_POST["sid"])) {
    $qid = $_POST["qid"];
    $sid = $_POST["sid"];
    // Perform database operations to remove the user from the queue_waiting table
    require_once 'db_handler.php';
    $select_query = "SELECT fn FROM queue_waiting WHERE id = ? AND session_id = ?;";
    $select_stmt = mysqli_stmt_init($conn);

    $query = "DELETE FROM queue_waiting WHERE id = ? AND session_id = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($select_stmt, $select_query) or !mysqli_stmt_prepare($stmt, $query)) {
        $response['error'] = "Could not prepare SQL statement";
    } else {
        mysqli_stmt_bind_param($select_stmt, "ss", $qid, $sid);
        mysqli_stmt_execute($select_stmt);

        $res = mysqli_stmt_get_result($select_stmt);

        if ($row = mysqli_fetch_assoc($res)) {
            $response["fn"] = $row["fn"];
        }

        mysqli_stmt_bind_param($stmt, "ss", $qid, $sid);
        mysqli_stmt_execute($stmt);

        $response['message'] = "User deleted successfuly.";
    }

    mysqli_stmt_close($stmt);
    mysqli_stmt_close($select_stmt);
} else {
    $response["error"] = "No POST request";
}
// Output the JSON response
echo json_encode($response);
exit;
?>