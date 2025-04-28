<?php
// This page meets Functional Requirement 1.a
session_start();  // connect to session

require_once 'db_connect_master.php';  // include once the db connect functions
require_once 'functs.php';  // include the main functions


if ($_SERVER['REQUEST_METHOD'] === 'POST') {  // if it's a post method
    // used to check correct format of email address
    if (only_user(dbconnect_select(),$_POST['email'])) {  //calls function to check password complexity
        $_SESSION['ERROR'] = "Cannot use that email, already registered";
        header("Location: login.php");
        exit; // Stop further execution
    }
    elseif (!pwrd_checker($_POST['password'], $_POST['cpassword'])) {  //calls function to check password complexity
        $_SESSION['ERROR'] = "Password related issue, try again";
        header("Location: register.php");
        exit; // Stop further execution
    } else {

// this code runs if the previous checks are ok
        try {
            if(reg_user(dbconnect_insert(),$_POST)) { // Assuming $conn is your database connection
                $_SESSION['SUCCESS'] = $_POST['email']." USER REGISTERED";
                header("Location: login.php");
                exit; // Stop further execution
            } else {
                $_SESSION['ERROR'] = "ADD USER FAIL, UNKNOWN ERROR";
                header("Location: register.php");
                exit; // Stop further execution
            }
        }
        catch(Exception $e) {
            // Handle database error within reg_admin or here.
            $_SESSION['ERROR'] = "USER REG ERROR: ". $e->getMessage();
            header("Location: register.php");
            exit; // Stop further execution
        }
    }
} else {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styles.css">
        <title>Rolsa Technologies - Registration</title>
    </head>
    <body>
    <!-- Header -->
    <header>
        <div class="logo">Rolsa Technologies</div>
        <div class="header-buttons">
            <a href="login.php"><button class="login-btn">Login</button></a>
            <a href="calc.php"><button class="nav-btn">Carbon Calculator</button></a>
            <a href="contact_us.php"><button class="nav-btn">Contact Us</button></a>
        </div>
        <img src="assets/Rolsa_Tech_Logo_Transparent.png" alt="Rolsa Technologies Logo" class="company-logo">
    </header>

    <!-- Main Content -->
    <main>
        <div class="content-container">
            <div class="text-content">
                <div class="section">
                    <h2>New User Registration</h2>

                    <?php echo usr_error(); ?>

                    <form method="post" action="register.php" class="login-form">
                        <div class="form-group">
                            <input type="text" name="email_address" placeholder="Email Address" required>
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" placeholder="Password" required>
                        </div>
                        <div class="form-group">
                            <input type="password" name="cpassword" placeholder="Confirm Password" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="fname" placeholder="First Name" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="sname" placeholder="Surname" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="addressln1" placeholder="Address Line 1" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="addressln2" placeholder="Address Line 2" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="city" placeholder="City / Town" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="postcode" placeholder="Post Code" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="phone" placeholder="Phone Number" required>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" value="Register" class="submit-btn">
                        </div>
                    </form>

                    <p>Already have an account? <a href="login.php" class="register-link">Login here</a></p>
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