<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("location: login.php?error=notloggedin");
    echo $_SESSION;
    exit();
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
        <a href="includes/logout.php"><button>Logout</button></a>
    </header>
    
    <main>
        <div id="welcome">
            <h2>Welcome back, <?php echo $_SESSION["username"] ?>!</h2>
            <a href="queue_creation.php"><button>Create a new queue</button></a>
        </div>

        <section class=queues>
            <h1>Your queues</h1><br>
            <table>
                <thead>
                    <tr>
                        <th>Queue ID</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        require_once "includes/fetch_queue-inc.php"
                    ?>
                </tbody>
            </table>
        </section>  
        <script src="js/open_queue.js"></script>
    </main>
    
    
    <footer>
        <p>&copy; 2023 FMIQueues</p>
    </footer>
</body>
</html>
