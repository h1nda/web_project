<?php
session_start();
$response = [];
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $qid = $_POST["qid"];
    $sid = $_POST["sid"];
    require_once 'db_handler.php';
    $select_stmt = $conn->prepare("SELECT fn FROM queue_waiting WHERE id = ? AND session_id = ?;");
    $del_stmt = $conn->prepare("DELETE FROM queue_waiting WHERE id = ? AND session_id = ?;");

    $select_stmt->execute([$qid, $sid]);
    $res = $select_stmt->get_result();

    if ($row = $res->fetch_assoc()) {
        $response["fn"] = $row["fn"];
    }

    $del_stmt->execute([$qid, $sid]);
    $response['message'] = "User deleted successfuly.";

} else {
    $response["error"] = "No POST request";
}
echo json_encode($response);
exit;
?>