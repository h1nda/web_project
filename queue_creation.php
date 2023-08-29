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
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>FMIQueues</h1>
        <a href="includes/logout.php"><button>Logout</button></a>
    </header>
    
    <main id="main-creation">
        <section class="form-wrapper">
                
            <h2>Create a new queue</h2>
                    <form id="creation-form" action="includes\queue_creation_logic.php" method="POST">
                        <label>Queue name:</label>
                        <input type="text" name="queue_name" required><br>

                        <label>Meeting link:</label>
                        <input type="url" name="link" placeholder="Google meet, Teams, jit.si, etc." required><br>

                        <label>Queue limit:</label>
                        <input type="number" name="queue_limit" min="1" max="100"><br>

                        <div id="radio">
                            <span>
                                <label>Entry Method:</label><br>
                                <input type="radio" id="entryInterval" name="entry_method" value="interval">
                                <label for="entryInterval">Let somebody in every X minutes</label><br>
                            </span>
                            
                            <span>
                                <input type="radio" id="entryManual" name="entry_method" value="manual" checked>
                                <label for="entryManual">When I let them in</label><br>
                            </span> 
                        </div>
                            
                        <div id="entryIntervalInput" style="display: none;">
                            <label>Interval Time (1-120 min):</label>
                            <input type="number" id="entryIntervalTime" name="entry_interval" min="1" max="120"><br>
                        </div>
                        
                        <script src="js/show_interval.js"></script>
                        
                        <button type="submit" name="submit">Create queue</button>
                    </form>
                    <a href="index.php"><button>Cancel</button></a>
                    

        </section>
        
    </main>
    
    <footer>
        <p>&copy; 2023 FMIQueues</p>
    </footer>
</body>
</html>
