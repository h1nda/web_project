<?php 
$sid = $_SESSION['session_id'];
require_once "db_handler.php";

$query = "SELECT * FROM queue_waiting WHERE session_id = ?;";
$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $query)) {
    header("location: register.php?error=dbfail");
    exit;
} else {
    mysqli_stmt_bind_param($stmt, "s", $sid);
    mysqli_stmt_execute($stmt);

    $res = mysqli_stmt_get_result($stmt);

    if (!$row = mysqli_fetch_assoc($res)) {
        session_destroy();
        header("location: login.php?error=kickedout");
        exit();
    }
}