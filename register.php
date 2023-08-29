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
    </header>
    
    <main>
        <section class="sections-wrapper">
            <section class="form-wrapper">
            
                <h2>Register</h2>
                    <form action="includes/register_logic.php" method="POST">
                    <input type="text" name="name" placeholder="Name" required>
                        <input type="text" name="username" placeholder="Username" required>
                        <input type="email" name="email" placeholder="E-mail" required>
                        <input type="password" name="pwd" placeholder="Password" required>
                        <input type="password" name="reppwd" placeholder="Confirm password" required>
                        
                        <button type="submit" name="submit">Sign Up</button>
                    </form>

                
                <a href="login.php">Have an account? Click here to login.</a>

                <?php
                if (isset($_GET["error"])) {
                    switch ($_GET["error"]) {
                        case "dbfail":
                            echo "<p>Something went wrong.</p>";
                            break;
                        case "usertaken":
                            echo "<p>User already exists.</p>";
                            break;
                        case "mismatchedpwd":
                            echo "<p>Passwords don't match.</p>";
                            break;
                        case "none":
                            echo "<p>Successful registration!</p>";
                            break;
                        }
                    }
                ?>
            </section>

        </section>
    </main>
    
    <footer>
        <p>&copy; 2023 FMIQueues</p>
    </footer>
</body>
</html>
