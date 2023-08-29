<?php
function matchPass($reppwd, $pwd) {
    return $reppwd == $pwd;
}

function userExists($conn, $username, $email) {
    $query = "SELECT * FROM users WHERE username = ? OR email = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $query)) {
        header("location: ../register.php?error=dbfail");
    } else {
        mysqli_stmt_bind_param($stmt, "ss", $username, $email);
        mysqli_stmt_execute($stmt);

        $res = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($res)) {
            return $row;
        } else {
            return false;
        }
    }

    mysqli_stmt_close($stmt);
}

function createUser($conn, $name, $username, $email, $pwd) {
    $query = "INSERT INTO users (name, username, email, pass) VALUES (?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $query)) {
        header("location: ../register.php?error=dbfail");
    } else {

        $pwdhash = password_hash($pwd, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt, "ssss", $name, $username, $email, $pwdhash);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("location: ../register.php?error=none");
        exit();
    }
}

function loginUser($conn, $username, $pwd) {
    $user = userExists($conn, $username, $username);
    if (!$user) {
        header("location: ../login.php?error=loginerror");
        exit();
    }

    $hashpwd = $user["pass"];
    $checkpwd = password_verify($pwd, $hashpwd);

    if (!$checkpwd) {
        header("location: ../login.php?error=loginerror");
        exit();
    }

    session_start();
    echo "Set user";
    $_SESSION["id"] = $user["id"];
    $_SESSION["username"] = $user["username"];
    header("location: ../index.php");
    exit();
}

function fetchQueues($conn) {
    // Fetch the queue data from the database using $_SESSION["id"]
    $userId = $_SESSION["id"];
    if (!$conn) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    // Query to fetch queue information
    $query = "SELECT queue_id FROM queues WHERE user_id = $userId";
    $result = mysqli_query($connection, $query);

    // Generate table rows dynamically
    $rows = '';
    while ($row = mysqli_fetch_assoc($result)) {
        $queueId = $row["queue_id"];
        $rows .= "<tr><td>$queueId</td></tr>";
    }

    mysqli_close($connection);
}