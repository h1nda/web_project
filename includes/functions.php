<?php
function matchPass($reppwd, $pwd) {
    return $reppwd == $pwd;
}

function userExists($conn, $username, $email) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?;");
    $stmt->execute([$username, $email]);
    $res = $stmt->get_result();

    if ($row = $res->fetch_assoc()) {
        return $row;
    } else {
        return false;
    }
}

function createUser($conn, $name, $username, $email, $pwd) {
    $stmt = $conn->prepare("INSERT INTO users (name, username, email, pass) VALUES (?, ?, ?, ?);");
    $pwdhash = password_hash($pwd, PASSWORD_DEFAULT);
    $stmt->execute([$name, $username, $email, $pwdhash]);
    header("location: ../register.php?error=none");
    exit();
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
    $_SESSION["id"] = $user["id"];
    $_SESSION["username"] = $user["username"];
    header("location: ../index.php");
    exit();
}