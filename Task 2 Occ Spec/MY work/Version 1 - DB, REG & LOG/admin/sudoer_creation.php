<?php
session_start();  // connects with or starts a session if not already existing

require_once '../db_connect_master.php';  // include once the db connect functions

require_once 'adm_functs.php';  // include once the admin functions

//require_once '../common_functions.php';

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

echo "<!DOCTYPE html>";

echo "<html lang='en'>";

echo "<head>";


echo "<title> Rtech One Time Admin Registration</title>";

echo "</head>";

echo "<body>";

echo "<div id='container'>";

echo "<div id='title'>";

echo "<h3 id='banner'>Rtech Admin one time registration</h3>";

echo "</div>";


echo "<div id='content'>";

echo admin_error($_SESSION);

echo "<h4> This is a one time registration for Rtech system</h4>";

echo "<br>";

echo "<form method='post' action='sudoer_creation.php'>";

echo "<input type='text' name='email' placeholder='Email' required><br>";

echo "<input type='password' name='password' placeholder='Password' required><br>";

echo "<input type='password' name='cpassword' placeholder='Confirm Password' required><br>";


echo "<input type='hidden' name='priv' value='super'><br>";

echo "<input type='submit' name='submit' value='Register'>";

echo "<br><br>";

echo "</div>";

echo "</div>";

echo "</body>";

echo "</html>";