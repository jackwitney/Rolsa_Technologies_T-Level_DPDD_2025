<?php
session_start();
require_once 'admin_functs.php';
require_once '../db_connect_master.php';
require_once '../functs.php';

if (isset($_SESSION['admin_ssnlogin'])){
    $_SESSION['ERROR'] = "Admin already logged in";
    header("Location: admin_dashboard.php");
    exit; // Stop further execution
}

elseif ($_SERVER['REQUEST_METHOD'] === 'POST'){  // if superuser doesn't exist and posted to this page
    try {  //try this code, catch errors

        $conn = dbconnect_select();
        $sql = "SELECT adm_id, email_address, password, adm_type FROM admins WHERE email_address = ?"; //set up the sql statement
        $stmt = $conn->prepare($sql); //prepares
        $stmt->bindParam(1,$_POST['email']);  //binds the parameters to execute
        $stmt->execute(); //run the sql code
        $result = $stmt->fetch(PDO::FETCH_ASSOC);  //brings back results
        $conn = null;  // nulls off the connection so cant be abused.

        if($result){  // if there is a result returned

            if (password_verify($_POST["password"], $result["password"])) { // verifies the password is matched
                $_SESSION["admin_ssnlogin"] = true;  // sets up the session variables
                $_SESSION["email_address"] = $_POST['email_address'];
                $_SESSION["adm_id"] = $result["adm_id"];
                $_SESSION["adm_type"] = $result["adm_type"];
                $_SESSION['SUCCESS'] = "Admin Successfully Logged In";
                header("location:admin_dashboard.php");  //redirect on success
                exit();

            } else{
                $_SESSION['ERROR'] = "Admin login passwords not match";
                header("Location: admin_login.php");
                exit; // Stop further execution
            }

        } else {
            $_SESSION['ERROR'] = "Admin user not found";
            header("Location: admin_login.php");
            exit; // Stop further execution

        }

    } catch (Exception $e) {
        $_SESSION['ERROR'] = "Admin login".$e->getMessage();
        header("Location: admin_login.php");
        exit; // Stop further execution
    }
}
else {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="admin_styles.css">
        <title>Rolsa Technologies - Admin Login</title>
    </head>
    <body>
    <!-- Header -->
    <header>
        <div class="logo">Rolsa Technologies Admin</div>
        <div class="header-buttons">
            <a href="../login.php"><button class="nav-btn">Main Site</button></a>
        </div>
        <img src="../assets/Rolsa_Tech_Logo_Transparent.png" alt="Rolsa Logo" class="company-logo">
    </header>

    <div id="content">
        <h4>Admin Login</h4>

        <?php echo admin_error($_SESSION); ?>

        <form method="post" action="admin_login.php">
            <input type="text" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" name="submit" value="Login">
        </form>
    </div>
    </body>
    </html>
    <?php
}
?>