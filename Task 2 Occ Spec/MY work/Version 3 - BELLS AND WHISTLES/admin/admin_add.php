<?php
// refactored code to put all the work into one page for adding an admin

session_start();  // connect to session if one has started

require_once 'admin_functs.php';  // include the admin functions
require_once '../db_connect_master.php';  // include once the db connect functions
require_once '../functs.php';  // include the main functions

if (!isset($_SESSION['admin_ssnlogin']) || $_SESSION['adm_type']!='super'){
    $_SESSION['ERROR'] = "Admin not logged in / not enough privileges.";
    header("Location: admin_login.php");
    exit; // Stop further execution
}

elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {  // if it's a post method
    // used to check correct format of email address

    if ($_POST['priv'] == "SUPER" and sudo_check(dbconnect_select())) {
        $_SESSION['ERROR'] = "Super admin already exists, go login";
        header("Location: admin_index.php");
        exit; // Stop further execution
    } elseif (!pwrd_checker($_POST['password'], $_POST['cpassword'])) {  //calls function to check password complexity
        $_SESSION['ERROR'] = "Password related issue, try again";
        header("Location: admin_add.php");
        exit; // Stop further execution
    } else {
// this code runs if the previous checks are ok
        try {
            $short_task = $_POST['priv']."REG";
            $long_task = $_POST['username']." registered as a ".$_POST['priv'];
            if(register_adm(dbconnect_insert(),$_POST)){
                $_SESSION['SUCCESS'] = $_POST['priv']." ADMIN REGISTERED";
                header("Location: admin_login.php");
                exit; // Stop further execution
            } else {
                $_SESSION['ERROR'] = "ADD ADMIN FAIL, UNKNOWN ERROR";
                header("Location: admin_dashboard.php");
                exit; // Stop further execution
            }
        }
        catch(Exception $e) {
            // Handle database error within reg_admin or here.
            $_SESSION['ERROR'] = "SUPER REG ERROR: ". $e->getMessage();
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
        <title>Rolsa Technologies - Add Admin</title>
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
        <a href="add_staff.php">Add Staff</a>
        <a href="admin_add.php" class="active">Add Admin</a>
    </div>

    <div id="content">
        <h4>Add New Admin</h4>

        <?php echo admin_error($_SESSION); ?>

        <form method="post" action="admin_add.php">
            <input type="text" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="cpassword" placeholder="Confirm Password" required>

            <label for="priv">Select User Role:</label>
            <select name="priv" id="priv">
                <option value="admin">Admin</option>
                <option value="priv user">Privileged User</option>
            </select>

            <input type="submit" name="submit" value="Register Admin">
        </form>
    </div>
    </body>
    </html>
    <?php
}
?>