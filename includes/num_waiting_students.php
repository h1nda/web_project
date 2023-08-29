<?php
include 'db_handler.php'; // Include your database connection script

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $qid = $_POST["qid"];

    // Query to count the number of waiting students for the specified queue
    $query = "SELECT COUNT(*) AS num_students FROM queue_waiting WHERE id = ?";
    $stmt = mysqli_stmt_init($conn);

    if (mysqli_stmt_prepare($stmt, $query)) {
        mysqli_stmt_bind_param($stmt, "s", $qid);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);

        // Send the count as a JSON response
        echo json_encode(["num_students" => $row["num_students"]]);
    }

    mysqli_stmt_close($stmt);
}
?>
