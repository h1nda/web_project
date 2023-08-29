<?php
if (isset($_POST["submit"])) {
    session_start();
    $qid = $_POST["queue-id"]; // Get the queue ID
    $fn = $_POST["fn"];

    // Store the queue ID and join timestamp in the session
    $_SESSION["session_id"] = session_create_id();
    $_SESSION["fn"] = $fn;

    require_once "db_handler.php";

    $query = "SELECT status FROM queue_info WHERE id=?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $query)) {
        header("location: ../login.php?error=unknown");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "s", $qid);
        mysqli_stmt_execute($stmt);

        $res = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($res)) {
            if ($row['status'] == 'closed') {
                header("location: ../login.php?error=queueclosed");
            exit();
            }
        } else {
            header("location: ../login.php?error=unknown");
            exit();
        }
    }
    mysqli_stmt_close($stmt);
    // Insert a record into the database (queue_waiting_list)
    // Perform your database insert operation here
    $query = "INSERT INTO queue_waiting (id, session_id, fn) VALUES (?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $query)) {
        header("location: ../login.php?error=unknown");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "sss", $qid, $_SESSION["session_id"], $fn);
        mysqli_stmt_execute($stmt);
    }
    mysqli_stmt_close($stmt);

    // Redirect to a confirmation page or the same page
    header("Location: ../waiting_room.php?qid=$qid");
    exit();
} else {
    header("location: ../login.php");
    exit();
}