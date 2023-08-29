<?php
    session_start();
    if (!isset($_GET["qid"])) {
        header("location: login.php?error=notloggedin");
        exit();
    }
    if (!isset($_SESSION["session_id"])) {
        header("location: login.php?error=kickedout");
        exit();
    }
    require_once "includes/check_user_session.php";
    require_once "includes/db_handler.php" ;
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
</head>
<body>
    <header>
        <h1>FMIQueues</h1>
    </header>
    <?php include_once "includes/chat_sidebar.php"; ?>
    
    <main>
        <section class="open-queue">
            <h2>QUEUEING for <?php echo $name?></h2>
            <p>Students in front of you: X</p>
            <!-- Displayed when the entry becomes true -->
            <a id="entryLink" href="<?php echo $link; ?>" style="display: none;">Enter the meeting!</a>
            <p id="timer" style="display: none;">Time remaining: <span id="countdown">1:00</span></p>
            <?php echo $_SESSION["session_id"]; ?>
        <script>
            // Define a function to poll for the user's entry flag
            var sid = "<?php echo $_SESSION["session_id"]; ?>";
            var qid = "<?php echo $qid; ?>";
        </script>
        <script type="module" src="js/entry.js"></script>
        <script type="module" src="js/user_session_end.js"></script>

        </section>
    </main>
    
    <footer>
        <p>&copy; 2023 FMIQueues</p>
    </footer>
</body>
</html>
