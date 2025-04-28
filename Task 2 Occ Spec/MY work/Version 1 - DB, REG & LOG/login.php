<?php
session_start();

require_once 'db_connect_master.php';
require_once 'functs.php';

if (isset($_SESSION['user_ssnlogin'])){
    $_SESSION['ERROR'] = "You are already logged in!";
    header("Location: dashboard.php");
    exit; // Stop further execution
}

elseif ($_SERVER['REQUEST_METHOD'] == 'POST'){  // if superuser doesn't exist and posted to this page
    echo "hello";
    try {  //try this code, catch errors

        $conn = dbconnect_select();
        $sql = "SELECT * FROM users WHERE email_address = ?"; //set up the sql statement
        $stmt = $conn->prepare($sql); //prepares
        $stmt->bindParam(1, $_POST['email_address']);  //binds the parameters to execute
        $stmt->execute(); //run the sql code
        $result = $stmt->fetch(PDO::FETCH_ASSOC);  //brings back results
        $conn = null;  // nulls off the connection so cant be abused.
//        if ($result) { // this code has been improved by AI as i was unable make it function as intended
//            if (pswdcheck($_POST["password"], $result["password"])) {
//                echo var_dump($result) . "<br>";
//                $_SESSION["user_ssnlogin"] = true;  // sets up the session variables
//                $_SESSION["email_address"] = $_POST['email_address'];
//                $_SESSION['SUCCESS'] = "User Successfully Logged In";
//                header("location:dashboard.php");  //redirect on success
//                exit;
//            } else {
//                $_SESSION['ERROR'] = "User login passwords not match";
//                header("Location: login.php");
//                exit; // Stop further execution
//            }


    if ($result) {
        // Re-establish the connection since you closed it
        $conn = dbconnect_select();

        // Call pswdcheck with correct parameters
        if (pswdcheck($conn, $_POST['email_address'])) {
            $_SESSION["user_ssnlogin"] = true;  // sets up the session variables
            $_SESSION["email_address"] = $_POST['email_address'];
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

    echo "<!DOCTYPE html>";

    echo "<html lang='en'>";

    echo "<head>";

    echo "<link rel='stylesheet' href='styles.css'>";

    echo "<title> RZL User Login</title>";

    echo "</head>";

    echo "<body>";

    echo "<div id='list container'>";

    echo "<div id='title'>";

    echo "<h3 id='banner'>RZL User System</h3>";

    echo "</div>";

    echo "<div id='content'>";

    echo "<h4> User Login</h4>";

    echo "<br>";

    echo usr_error($_SESSION);

    echo "<form method='post' action='login.php'>";

    echo "<input type='text' name='email_address' placeholder='email address' required><br>";

    echo "<input type='password' name='password' placeholder='Password' required><br>";

    echo "<input type='submit' name='submit' value='Login'>";

    echo "</form>";

    echo "<br><br>";

    echo "</div>";

    echo "</div>";

    echo "</body>";

    echo "</html>";
}