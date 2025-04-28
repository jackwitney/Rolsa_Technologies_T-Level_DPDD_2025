<?php
session_start();  // connects with or starts a session if not already existing

require_once '../db_connect_master.php';  // include once the db connect functions
require_once 'admin_functs.php';  // include once the admin functions

if (sudo_check(dbconnect_select())) {  // calls function in admin_functs to check if superuser exists.
    $_SESSION['ERROR'] = "ADMIN ALREADY EXISTS, LOGIN or ASK to be registered";  // sets the error session variable to be read out by the next page
    header('location: admin_login.php');  // redirects to the needed new page.
    exit;
}
elseif ($_SERVER['REQUEST_METHOD'] === 'POST'){  // if superuser doesn't exist and posted to this page
    try {
        if(register_adm(dbconnect_insert(),$_POST)) {
            $_SESSION['SUCCESS'] = "ADMIN REGISTERED";
            header("Location: admin_login.php");
            exit; // Stop further execution
        } else {
            $_SESSION['ERROR'] = "SUPER FAIL, UNKNOWN ERROR";
            header("Location: sudoer_creation.php");
            exit; // Stop further execution
        }
    }
    catch(Exception $e) {
        // Handle database error within reg_admin or here.
        $_SESSION['ERROR'] = "SUPER REG ERROR: ". $e->getMessage();
        header("Location: sudoer_creation.php");
        exit; // Stop further execution
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_styles.css">
    <title>Rolsa Technologies - One Time Admin Registration</title>
</head>
<body>
<!-- Header -->
<header>
    <div class="logo">Rolsa Technologies Admin Setup</div>
    <div class="header-buttons">
        <a href="../index.php"><button class="nav-btn">Main Site</button></a>
    </div>
    <img src="../assets/Rolsa_Tech_Logo_Transparent.png" alt="Rolsa Logo" class="company-logo">
</header>

<div id="content">
    <h3>Rolsa Technologies Admin Setup</h3>

    <?php echo admin_error($_SESSION); ?>

    <p>This is a one-time registration for the Rolsa Technologies system. Once a super admin is registered, this page will no longer be accessible.</p>

    <form method="post" action="sudoer_creation.php">
        <input type="text" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="cpassword" placeholder="Confirm Password" required>
        <input type="hidden" name="priv" value="super">
        <input type="submit" name="submit" value="Register Super Admin">
    </form>
</div>
</body>
</html>