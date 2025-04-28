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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css"> <!-- Link to external CSS file -->
    <title>Rolsa Technologies - Book Appointment</title>
</head>
<body>
<!-- Header -->
<header>
    <div class="logo">Rolsa Technologies</div>
    <div class="header-buttons">
        <a href="dashboard.php"><button class="nav-btn">Dashboard</button></a>
        <a href="calc.php"><button class="nav-btn">Carbon Calculator</button></a>
        <a href="contact_us.php"><button class="nav-btn">Contact Us</button></a>
        <a href="logout.php"><button class="nav-btn">Logout</button></a>
    </div>
    <img src="assets/Rolsa_Tech_Logo_Transparent.png" alt="Rolsa Logo" class="company-logo">
</header>

<!-- Main Content -->
<main>
    <div class="content-container">
        <div class="text-content">
            <div class="section">
                <h2>Book Your Appointment</h2>

                <?php echo usr_error(); ?> <!-- Display any error messages from session -->

                <form action="book_appt.php" method="post" class="login-form"> <!-- Reuse login-form class for styling -->
                    <div class="form-group">
                        <label for="meeting-time">Choose a time for your appointment:</label>
                        <input type="datetime-local" id="meeting-time" name="meeting-time"
                               value="<?php echo get_time("current"); ?>"
                               min="<?php echo get_time("current"); ?>"
                               max="<?php echo get_time("future"); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="staff_pick">Choose a staff member:</label>
                        <select name="staff_pick" id="staff_pick" required>
                            <?php
                            $staff = get_appt_staff(dbconnect_select()); // Get staff list from database
                            foreach ($staff as $staff_member) { // Loop through each staff member
                                echo "<option value='".$staff_member['staff_id']."'>".$staff_member['fname']." ".$staff_member['sname']." - ". strtolower($staff_member['specialty'])."</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="apt_type">Choose an appointment type:</label>
                        <select name="apt_type" id="apt_type" required>
                            <option value="INSTALLER">Installation</option>
                            <option value="CONSULTANT">Consultation</option>
                            <option value="MAINTENANCE">Maintenance</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="product">Select product:</label>
                        <select name="product" id="product" required>
                            <option value="Solar Panels">Solar Panels</option>
                            <option value="Heat Pump">Heat Pump</option>
                            <option value="Smart Heating">Smart Heating</option>
                            <option value="Insulation">Insulation</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <input type="submit" name="submit" value="Book Appointment" class="submit-btn">
                    </div>
                </form>
            </div>
        </div>

        <div class="image-container">
            <img src="assets/Rolsa_Tech_Logo_Transparent.png" alt="Rolsa Technologies" class="logo-large">
        </div>
    </div>
</main>
</body>
</html>