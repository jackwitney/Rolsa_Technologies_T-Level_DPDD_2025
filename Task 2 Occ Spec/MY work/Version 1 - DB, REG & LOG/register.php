<?php
// page to allow users to register to the system

session_start();  // connect to session if one has started

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

}
else {

    echo "<!DOCTYPE html>";

    echo "<html lang='en'>";

    echo "<head>";
    echo "<title> RZL User Registration</title>";
    echo "<link rel='stylesheet' href='styles.css'>";
    echo "</head>";

    echo "<body>";

    echo "<div id='container'>";

    echo "<div id='title'>";

    echo "<h3 id='banner'>RZL User Registration</h3>";

    echo "</div>";

    include 'user_nav.php';

    echo "<div id='content'>";

    echo "<h4> New User Registration </h4>";

    echo "<br>";

    echo usr_error();

    echo "<br>";

    echo "<form method='post' action='register.php'>";

    echo "<input type='text' name='email_address' placeholder='E-Mail Address' required><br>";

    echo "<input type='password' name='password' placeholder='Password' required><br>";

    echo "<input type='password' name='cpassword' placeholder='Confirm Password' required><br>";

    echo "<input type='text' name='fname' placeholder='First Name' required><br>";

    echo "<input type='text' name='sname' placeholder='Surname' required><br>";

    echo "<input type='text' name='addressln1' placeholder='Address Line 1' required><br>";

    echo "<input type='text' name='addressln2' placeholder='Address Line 2' required><br>";

    echo "<input type='text' name='city' placeholder='City / Town' required><br>";

    echo "<input type='text' name='postcode' placeholder='Post Code' required><br>";

    echo "<input type='text' name='phone' placeholder='Phone Number' required><br>";

    echo "<input type='submit' name='submit' value='Register'>";

    echo "<br><br>";

    echo "</div>";

    echo "</div>";

    echo "</body>";

    echo "</html>";
}