<?php
$host = "localhost";
$dbuser = "root";
$pass = "";
$dbname = "fmi_queues";

$conn = mysqli_connect($host, $dbuser, $pass, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}