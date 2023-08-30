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
    $stmt = $conn->prepare($query);

    if ($method == 'interval') {
       $stmt->execute([$qid, $_SESSION["id"], $link, $queue_name, $limit, $method, $interval]);
    } else {
        $stmt->execute([$qid, $_SESSION["id"], $link, $queue_name, $limit, $method]);
    }
        
    header("location: ../index.php?successful");
    exit;
} else {
    header("location: ../queue_creation.php?error=unknown");
    exit;
}