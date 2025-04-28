<?php
session_start(); // Initialize the session to store user data between pages

require_once "functs.php"; // Import custom functions
require_once "db_connect_master.php"; // Import database connection functions

// Check if user is logged in by verifying session variable exists
if(!isset($_SESSION['user_ssnlogin'])){
    $_SESSION['ERROR'] = "You are not logged in!"; // Set error message in session
    header("Location: login.php"); // Redirect to login page
    exit; // Stop execution of the rest of the script
}

// Process form submission - only execute if method is POST
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate selected staff and appointment using custom functions
    if (valid_staff(dbconnect_select(), $_POST) && valid_appointment(dbconnect_select(), $_POST)) {
        if(commit_booking(dbconnect_insert(), $_POST)){ // Try to insert booking into database
            $_SESSION['SUCCESS'] = "Appointment Booked Successfully!"; // Set success message
            header("Location: book_appt.php"); // Refresh the page
            exit; // Stop execution
        }
    } else {
        $_SESSION['ERROR'] = "Invalid staff selection or appointment time"; // Set error message
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="styles.css"> <!-- Link to external CSS file -->
    <title>Booking System</title>
</head>
<body>
<div id="container"> <!-- Main container for page layout -->
    <div id="content"> <!-- Content container -->
        <h4>Book your appointment</h4>
        <br>
        <?php echo usr_error(); ?> <!-- Display any error messages from session -->
        <br>
        <form action="book_appt.php" method="post"> <!-- Form submits to this same page -->
            <label for="meeting-time">Choose a time for your appointment: </label>
            <input type="datetime-local" id="meeting-time" name="meeting-time"
                   value="<?php echo get_time("current"); ?>" <!-- Set default time to current time -->
            min="<?php echo get_time("current"); ?>" <!-- Set minimum time to current time -->
            max="<?php echo get_time("future"); ?>" <require/> <!-- Set maximum time to future date and make field required -->
            <br><br>

            <label for="staff_pick">Choose a staff member: </label>
            <select name="staff_pick" required> <!-- Dropdown for staff selection with required attribute -->
                <?php
                $staff = get_appt_staff(dbconnect_select()); // Get staff list from database
                foreach ($staff as $staff_member) { // Loop through each staff member
                    echo "<option value='".$staff_member['staff_id']."'>".$staff_member['fname']." ".$staff_member['sname']." - ". strtolower($staff_member['specialty'])."</option>"; // Create option with ID as value and formatted name+specialty as display text
                }
                ?>
            </select>
            <br><br>

            <label for="apt_type">Choose an appointment type: </label>
            <select name="apt_type" required> <!-- Dropdown for appointment type -->
                <option value="INSTALLER">Installation</option>
                <option value="CONSULTANT">Consultation</option>
                <option value="MAINTENANCE">Maintenance</option>
            </select>
            <br><br>

            <label for="product">Select product:</label>
            <select name="product" required> <!-- Dropdown for product selection -->
                <option value="Solar Panels">Solar Panels</option>
                <option value="Heat Pump">Heat Pump</option>
                <option value="Smart Heating">Smart Heating</option>
                <option value="Insulation">Insulation</option>
            </select>
            <br><br>

            <input type="submit" name="submit" value="Book Appointment"> <!-- Submit button -->
        </form>
    </div>
</div>
</body>
</html>