<?php
    session_start();
    if (!isset($_SESSION["id"])) {
        header("location: login.php?error=notloggedin");
        echo $_SESSION;
        exit();
    }
    if (!isset($_GET["qid"])) {
        header("location: index.php?error=unopenedqueue");
        echo $_SESSION;
        exit();
    }
    require_once("includes/db_handler.php");
    $qid = $_GET['qid'];

    $query = "SELECT * FROM queue_info WHERE id=?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $query)) {
        header("location: ../index.php?error=unknown");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "s", $qid);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($res)) {
            $interval = $row["interval_time"];
            $name = $row["queue_name"];
            $link = $row["link"];

            $update_q = "UPDATE queue_info SET status = 'open' WHERE id = ? AND user_id = ?;";
            if (!mysqli_stmt_prepare($stmt, $update_q)) {
                header("location: ../index.php?error=unknown");
                exit();
            }
            mysqli_stmt_bind_param($stmt, "ss", $qid, $_SESSION['id']);
            mysqli_stmt_execute($stmt);

        } else {
            echo "Queue not found?";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FMI queues</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/sidebar.css">
    <script src="js/fetch_messages.js"></script>
</head>
<body>
    <header>
        <h1>FMIQueues</h1>
    </header>
    <?php include_once "includes/chat_sidebar.php"; ?>
    
    <main>
        <section class="open-queue">
            <h2><?php echo $name?> is OPEN</h2>
            <button id="copy-button">Copy link to queue</button>
            <p id="students" style="display:block;">Students Waiting: <span id="numStudents">0</span></p>
            <p id="no-students" style="display:none;">No students in queue.</p>
            <button id="invite-button">Invite next</button>
            <p id="timer" style="display: none;">Time remaining: <span id="countdown">1:00</span></p>
            <a href="index.php"><button id="close-button">Close queue</button></a>

            <?php if ($interval) { ?>
                <p>Queue Interval: <?php echo $interval; ?> minutes</p>
                <div id="interval_timer">Countdown: <span id="interval_countdown"></span></div>
                <script>
                    var intervalInMinutes = <?php echo $interval; ?>;
                    var qid = "<?php echo $qid; ?>";
                </script>
                <script type="module" src="js/countdown_timer.js"></script>
            <?php } ?>

            <script>
                var qid = "<?php echo $qid; ?>";
                var joinlink = window.location.origin + "/web_project/login.php?qid=" + encodeURIComponent(qid);
                navigator.clipboard.writeText(joinlink);
            </script>

            <script type="module" src="js/send_invite.js"></script>
            <script src="js/poll_waiting_students.js"></script>
            <script src="js/close_queue.js"></script>
            <script src=js/send_message.js></script>
            

        </section>
    </main>
    
    <footer>
        <p>&copy; 2023 FMIQueues</p>
    </footer>
</body>
</html>
