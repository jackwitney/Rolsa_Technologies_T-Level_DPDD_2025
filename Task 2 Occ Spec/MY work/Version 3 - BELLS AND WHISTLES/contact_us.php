<?php
session_start();
require_once 'functs.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Rolsa Technologies - Contact Us</title>
</head>
<body>
<!-- Header -->
<header>
    <div class="logo">Rolsa Technologies</div>
    <div class="header-buttons">
        <!-- For contact_us.php -->
        <div class="header-buttons">
            <?php if(isset($_SESSION['user_ssnlogin'])): ?>
                <a href="dashboard.php"><button class="nav-btn">Dashboard</button></a>
                <a href="book_appt.php"><button class="nav-btn">Book Appointment</button></a>
                <a href="calc.php"><button class="nav-btn">Carbon Calculator</button></a>
                <a href="logout.php"><button class="nav-btn">Logout</button></a>
            <?php else: ?>
                <a href="calc.php"><button class="nav-btn">Carbon Calculator</button></a>
                <a href="register.php"><button class="register-btn">Register</button></a>
                <a href="login.php"><button class="login-btn">Login</button></a>
            <?php endif; ?>
        </div>
    </div>
    <img src="assets/Rolsa_Tech_Logo_Transparent.png" alt="Rolsa Logo" class="company-logo">
</header>

<!-- Main Content -->
<main>
    <div class="content-container">
        <div class="text-content">
            <div class="section">
                <h2>Contact Us</h2>

                <p>We'd love to hear from you! If you have any questions about our renewable energy solutions or would like to schedule a consultation, please fill out the form below or use our direct contact information.</p>

                <form class="login-form">
                    <div class="form-group">
                        <label for="name">Your Name</label>
                        <input type="text" id="name" name="name" placeholder="Enter your name">
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email">
                    </div>

                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <input type="text" id="subject" name="subject" placeholder="What's this regarding?">
                    </div>

                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" rows="5" placeholder="Type your message here"></textarea>
                    </div>

                    <div class="form-group">
                        <input type="button" value="Send Message" class="submit-btn">
                    </div>
                </form>
            </div>
        </div>

        <div class="image-container">
            <div class="contact-info">
                <h3>Our Information</h3>

                <div class="contact-detail">
                    <strong>Address:</strong>
                    <p>123 Green Energy Way<br>Sustainable City, SC1 2RE<br>United Kingdom</p>
                </div>

                <div class="contact-detail">
                    <strong>Phone:</strong>
                    <p>+44 (0)123 456 7890</p>
                </div>

                <div class="contact-detail">
                    <strong>Email:</strong>
                    <p>info@rolsatech.co.uk</p>
                </div>

                <div class="contact-detail">
                    <strong>Business Hours:</strong>
                    <p>Monday-Friday: 9am-5pm<br>Saturday: 10am-2pm<br>Sunday: Closed</p>
                </div>
            </div>
        </div>
    </div>
</main>
</body>
</html>