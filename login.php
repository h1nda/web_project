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
    </header>
    
    <main id="login-page">
        <section class="sections-wrapper">

            <section id="teacher-section">
                <h2>For Teachers</h2>

                <div class="form-wrapper">
                    <h3>Log in</h3>
                    <form action="includes/login_logic.php" action method="POST">
                        <input type="text" name="username" placeholder="Username or e-mail" required>
                        <input type="password" name="pwd" placeholder="Password" required>
                        <button type="submit" name="submit">Log In</button>
                    </form>

                    <?php
                    if (isset($_GET["error"])) {
                        if ($_GET["error"] == "loginerror") {
                            echo "<p>Invalid login information.</p>";
                        }
                    }
                    ?>
                </div>
                
                <a href="register.php"><button>Create a new account</button></a>
            </section>
            
            <section id="student-section">
                <h2>For Students</h2>
                
                <div class="form-wrapper">
                    <h3>Join Queue</h3>
                    <form action="includes/join_logic.php" method="POST">
                        <input type="text" name="fn" placeholder="FN" required><br>
                        <input type="text" name="queue-id" placeholder="Queue ID" <?php if (isset($_GET["qid"])) { echo 'value="' . $_GET["qid"] . '"'; } ?> required><br>
                        <button type="submit" name="submit">Join</button>
                    </form>
                </div>

            </section>

        </section>
        
    </main>
    <?php
            if (isset($_GET["error"])) {
                if ($_GET["error"] == "notloggedin") {
                    echo "<p>Please log-in first.</p>";
                }
            }
    ?>
    
    <footer>
        <p>&copy; 2023 FMIQueues</p>
    </footer>
</body>
</html>
