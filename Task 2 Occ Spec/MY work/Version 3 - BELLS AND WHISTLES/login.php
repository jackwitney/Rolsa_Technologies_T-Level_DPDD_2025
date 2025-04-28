<?php
// this login page helps me meet functional requirements 1.b
session_start();

require_once 'db_connect_master.php';
require_once 'functs.php';

if (isset($_SESSION['user_ssnlogin'])){
    $_SESSION['ERROR'] = "You are already logged in!";
    header("Location: dashboard.php");
    exit; // Stop further execution
}

elseif ($_SERVER['REQUEST_METHOD'] == 'POST'){  // if superuser doesn't exist and posted to this page
    try {  //try this code, catch errors

        $conn = dbconnect_select();
        $sql = "SELECT * FROM users WHERE email_address = ?"; //set up the sql statement
        $stmt = $conn->prepare($sql); //prepares
        $stmt->bindParam(1, $_POST['email_address']);  //binds the parameters to execute
        $stmt->execute(); //run the sql code
        $result = $stmt->fetch(PDO::FETCH_ASSOC);  //brings back results
        $conn = null;  // nulls off the connection so cant be abused.

        if ($result) {
            // Re-establish the connection since you closed it
            $conn = dbconnect_select();

            // Call pswdcheck with correct parameters
            if (pswdcheck($conn, $_POST['email_address'])) {
                $_SESSION["user_ssnlogin"] = true;  // sets up the session variables
                $_SESSION["email_address"] = $_POST['email_address'];
                $_SESSION["user_id"] = $result["user_id"]; // Store the user ID in session
                $_SESSION['SUCCESS'] = "User Successfully Logged In";
                header("location:dashboard.php");  //redirect on success
                exit;
            } else {
                $_SESSION['ERROR'] = "User login passwords not match";
                header("Location: login.php");
                exit; // Stop further execution
            }

        } else {
            $_SESSION['ERROR'] = "User not found";
            header("Location: register.php");
            exit; // Stop further execution
        }

    } catch (Exception $e) {
        $_SESSION['ERROR'] = "User login".$e->getMessage();
        header("Location: user_login.php");
        exit; // Stop further execution
    }
}

else {
    ?>
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel='stylesheet' href='styles.css'>
        <title>Rolsa Technologies - Login</title>
    </head>
    <body>
    <!-- Header -->
    <header>
        <div class="logo">Rolsa Technologies</div>
        <div class="header-buttons">
            <a href="register.php"><button class="register-btn">Register</button></a>
            <a href="calc.php"><button class="nav-btn">Carbon Calculator</button></a>
            <a href="contact_us.php"><button class="nav-btn">Contact Us</button></a>
        </div>
        <img src="assets/Rolsa_Tech_Logo_Transparent.png" alt="Rolsa Logo" class="company-logo">
    </header>

    <!-- Main Content -->
    <main>
        <div class="content-container">
            <div class="text-content">
                <div class="section">
                    <h2>Login to Your Account</h2>

                    <?php echo usr_error($_SESSION); ?>

                    <form method="post" action="login.php" class="login-form">
                        <div class="form-group">
                            <input type="text" name="email_address" placeholder="Email Address" required>
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" placeholder="Password" required>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" value="Login" class="submit-btn">
                        </div>
                    </form>

                    <p>Don't have an account? <a href="register.php" class="register-link">Register here</a></p>
                </div>
            </div>

            <div class="image-container">
                <img src="assets/Rolsa_Tech_Logo_Transparent.png" alt="Rolsa Technologies" class="logo-large">
            </div>
        </div>
    </main>
    </body>
    </html>
    <?php
}
?>