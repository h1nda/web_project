<?php

if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $pwd = $_POST["pwd"];

    require_once "db_handler.php";
    require_once "functions.php";

    loginUser($conn, $username, $pwd);
} else {
    header("location: ../login.php");
    exit();
}