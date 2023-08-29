<?php
if (isset($_POST["submit"])) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $pwd = $_POST["pwd"];
    $reppwd = $_POST["reppwd"];
    $email = $_POST["email"];
    $username = $_POST["username"];

    require_once 'db_handler.php';
    require_once 'functions.php';

    if (!matchPass($reppwd, $pwd)) {
        header("location: ../register.php?error=mismatchedpwd");
        exit();
    }

    if (userExists($conn, $username, $email)) {
        header("location: ../register.php?error=usertaken");
        exit();
    }

    createUser($conn, $name, $username, $email, $pwd);
}
else {
    header("location: ../register.php");
}