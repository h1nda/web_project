<?php
if (isset($_POST["submit"])) {
    session_start();
    $qid = $_POST["queue-id"]; // Get the queue ID
    $fn = $_POST["fn"];

    // Store the queue ID and join timestamp in the session
    $_SESSION["session_id"] = session_create_id();
    $_SESSION["fn"] = $fn;

    require_once "db_handler.php";

    $stmt = $conn->prepare("SELECT status FROM queue_info WHERE id=?;");
    $stmt->execute([$qid]);
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) {

        if ($row['status'] == 'closed') {
            header("location: ../login.php?error=queueclosed");
            exit;
        }
    } else {
        header("location: ../login.php?error=queuedoesntexist");
        exit;
    }
    $stmt_add = $conn->prepare("INSERT INTO queue_waiting (id, session_id, fn) VALUES (?, ?, ?);");
    $stmt_add->execute([$qid, $_SESSION["session_id"], $fn]);

    header("Location: ../waiting_room.php?qid=$qid");
    exit;
} else {
    header("location: ../login?error=illegaljoin.php");
    exit;
}
