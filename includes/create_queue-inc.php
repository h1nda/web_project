<?php 
session_start();
if (isset($_POST["submit"])) {
    $queue_name = $_POST["queue_name"];
    $link = $_POST["link"];
    $limit = $_POST["queue_limit"];
    $method = $_POST["entry_method"];

    

    require_once "db_handler.php";

    $qid = uniqid();

    if ($method == 'interval') {
        $interval = $_POST["entry_interval"];
        $query = "INSERT INTO queue_info (id, user_id, link, queue_name, queue_limit, entry_method, interval_time) VALUES (?, ?, ?, ?, ?, ?, ?);";
    } else {
        $query = "INSERT INTO queue_info (id, user_id, link, queue_name, queue_limit, entry_method) VALUES (?, ?, ?, ?, ?, ?);";
    }
    

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $query)) {
        header("location: ../queue_creation.php?error=dbfail");
    } else {
        if ($method == 'interval') {
            mysqli_stmt_bind_param($stmt, "sissisi", $qid, $_SESSION["id"], $link, $queue_name, $limit, $method, $interval);
        } else {
            mysqli_stmt_bind_param($stmt, "sissis", $qid, $_SESSION["id"], $link, $queue_name, $limit, $method);
        }
        
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("location: ../index.php?error=none");
        exit();
        }
} else {
    header("location: ../queue_creation.php?error=fillform");
    exit();
}
