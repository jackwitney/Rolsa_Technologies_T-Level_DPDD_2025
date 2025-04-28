<?php
// refactored code to put all the work into one page for adding an admin

session_start();  // connect to session if one has started

require_once 'admin_functs.php';  // include the admin functions
require_once '../db_connect_master.php';  // include once the db connect functions
require_once '../functs.php';


if (!isset($_SESSION['admin_ssnlogin'])){
    $_SESSION['ERROR'] = "Admin not logged in / not enough privileges.";
    header("Location: admin_login.php");
    exit; // Stop further execution
}

elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {  // if it's a post method
    if (!valid_email($_POST['email_address'])) {
        $_SESSION['ERROR'] = "Email must be a company email (@rtech.co.uk)";
        header("Location: admin_dashboard.php");
        exit; // Stop further execution
    }

    if (!pwrd_checker($_POST['password'], $_POST['cpassword'])) {  //calls function to check password complexity
        $_SESSION['ERROR'] = "Password related issue, try again";
        header("Location: admin_dashboard.php");
        exit; // Stop further execution
    } else {
// this code runs if the previous checks are ok
        try {
            if(reg_staff(dbconnect_insert(),$_POST)) { //  $conn is database connection
                $_SESSION['SUCCESS'] = $_POST['specialty']." STAFF REGISTERED";
                header("Location: admin_dashboard.php");
                exit; // Stop further execution
            } else {
                $_SESSION['ERROR'] = "ADD STAFF FAIL, UNKNOWN ERROR";
                header("Location: admin_dashboard.php");
                exit; // Stop further execution
            }
        }
        catch(Exception $e) {
            // Handle database error within reg_admin or here.
            $_SESSION['ERROR'] = "STAFF REG ERROR: ". $e->getMessage();
            header("Location: admin_dashboard.php");
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
        <link rel="stylesheet" href="admin_styles.css">
        <title>Rolsa Technologies - Add Staff</title>
    </head>
    <body>
    <!-- Header -->
    <header>
        <div class="logo">Rolsa Technologies Admin</div>
        <div class="header-buttons">
            <a href="../index.php"><button class="nav-btn">Main Site</button></a>
            <a href="admin_logout.php"><button class="nav-btn">Logout</button></a>
        </div>
        <img src="../assets/Rolsa_Tech_Logo_Transparent.png" alt="Rolsa Logo" class="company-logo">
    </header>

    <!-- Admin Navigation -->
    <div class="admin-nav">
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="add_staff.php" class="active">Add Staff</a>
        <?php if(isset($_SESSION['adm_type']) && $_SESSION['adm_type'] == 'super'): ?>
            <a href="admin_add.php">Add Admin</a>
        <?php endif; ?>
    </div>

    <div id="content">
        <h4>Add New Staff</h4>

        <?php echo admin_error($_SESSION); ?>

        <form method="post" action="add_staff.php">
            <input type="text" name="email_address" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="cpassword" placeholder="Confirm Password" required>
            <input type="text" name="fname" placeholder="First Name" required>
            <input type="text" name="sname" placeholder="Surname" required>

            <label for="role">Job Role:</label>
            <select name="role" id="role">
                <option value="CONSULTANT">Consultant</option>
                <option value="INSTALLER">Installer</option>
                <option value="MAINTENANCE">Maintenance</option>
            </select>

            <input type="submit" name="submit" value="Register Staff">
        </form>
    </div>
    </body>
    </html>
    <?php
}
?>