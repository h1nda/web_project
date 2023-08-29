<?php 
$sid = $_POST['sid'];
require_once "db_handler.php";

$query = "SELECT * FROM queue_waiting WHERE session_id = ?;";
$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $query)) {
    header("Content-Type: application/json");
    echo json_encode(["error" => "Database failure"]);
    exit;
} else {
    mysqli_stmt_bind_param($stmt, "s", $sid);
    mysqli_stmt_execute($stmt);

    $res = mysqli_stmt_get_result($stmt);

    if (!$row = mysqli_fetch_assoc($res)) {
        header("Content-Type: application/json");
        echo json_encode(["message" => "Student left", "student_id" => $sid]);
        exit;
    }
}
header("Content-Type: application/json");
echo json_encode(["message" => "Student has not clicked link"]);