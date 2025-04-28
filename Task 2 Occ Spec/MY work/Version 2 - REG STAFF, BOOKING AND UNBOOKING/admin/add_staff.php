<?php
// refactored code to put all the work into one page for adding an admin

session_start();  // connect to session if one has started

require_once 'adm_functs.php';  // include the admin functions
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

}
else {

    echo "<!DOCTYPE html>";

    echo "<html lang='en'>";

    echo "<head>";
    echo "<title> RZL Add Staff Page</title>";
    echo "<link rel='stylesheet' href='admin_styles.css'>";
    echo "</head>";

    echo "<body>";

    echo "<div id='container'>";

    include_once "nav.php";

    echo "<div id='content'>";

    echo "<h4> Add New Staff </h4>";

    echo "<br>";

    echo admin_error($_SESSION);

    echo "<br>";

    echo "<form method='post' action='add_staff.php'>";

    echo "<input type='text' name='email_address' placeholder='Email' required><br>";

    echo "<input type='password' name='password' placeholder='Password' required><br>";

    echo "<input type='password' name='cpassword' placeholder='Confirm Password' required><br>";

    echo "<input type='text' name='fname' placeholder='First Name' required><br>";

    echo "<input type='text' name='sname' placeholder='Surname' required><br>";


    echo "<label for='specialty'> Job Role:</label>";
    echo "<select name='role'>";
    echo "<option value='CONSULTANT'>Consultant</option>";
    echo "<option value='INSTALLER'>Installer</option>";
    echo "<option value='MAINTENANCE'>Maintenance</option>";
    echo "</select><br>";

    echo "<input type='submit' name='submit' value='Register'>";

    echo "<br><br>";

    echo "</div>";

    echo "</div>";

    echo "</body>";

    echo "</html>";
}