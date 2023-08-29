<?php
session_start();
include 'db_handler.php'; // Include your database connection script
$response = [];
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["sid"])) {
        $sid = $_POST["sid"];

        // Prepare and execute the SQL statement to check the user's entry flag
        $query = "SELECT enter FROM queue_waiting WHERE session_id = ?;";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $query)) {
            $response["error"] = "Error prepping statement";
            
        } else {
            mysqli_stmt_bind_param($stmt, "s", $sid);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)) {
                $response["message"] = "Successful fetch.";
                $response["enter"] = $row['enter'] == 1;
            } else {
                $response["error"] = "No row found.";
            }
        }

        mysqli_stmt_close($stmt);
    }
}
header("Content-Type: application/json");
echo json_encode($response);
?>
