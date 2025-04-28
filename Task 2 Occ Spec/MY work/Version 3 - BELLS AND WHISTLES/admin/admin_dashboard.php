<?php
// this page will meet Functional Requirement 4.a 4.b and 4.c if / when the exact desires of the client are finalised
session_start();

// Check if admin is logged in
if(!isset($_SESSION['admin_ssnlogin'])){
    $_SESSION['ERROR'] = "Admin not logged in";
    header("Location: admin_login.php");
    exit; // Stop further execution
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_styles.css">
    <title>Rolsa Technologies - Admin Dashboard</title>
</head>
<body>
<!-- Header -->
<header>
    <div class="logo">Rolsa Technologies Admin</div>
    <div class="header-buttons">
        <a href="../login.php"><button class="nav-btn">Main Site</button></a>
        <a href="admin_logout.php"><button class="nav-btn">Logout</button></a>
    </div>
    <img src="../assets/Rolsa_Tech_Logo_Transparent.png" alt="Rolsa Logo" class="company-logo">
</header>

<!-- Admin Navigation -->
<div class="admin-nav">
    <a href="admin_dashboard.php" class="active">Dashboard</a>
    <a href="add_staff.php">Add Staff</a>
    <?php if(isset($_SESSION['adm_type']) && $_SESSION['adm_type'] == 'super'): ?>
        <a href="admin_add.php">Add Admin</a>
    <?php endif; ?>
</div>

<div id="container">
    <h3>Admin Dashboard</h3>

    <?php echo isset($_SESSION['SUCCESS']) ? '<div class="success-message">'.$_SESSION['SUCCESS'].'</div>' : ''; ?>
    <?php echo isset($_SESSION['ERROR']) ? '<div class="error-message">'.$_SESSION['ERROR'].'</div>' : ''; ?>

    <!-- Dashboard Statistics -->
    <div class="dashboard-stats">
        <div class="stat-card">
            <div class="stat-label">Total Users</div>
            <div class="stat-number">158</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Active Bookings</div>
            <div class="stat-number">24</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Staff Members</div>
            <div class="stat-number">12</div>
        </div>
    </div>

    <div id="content">
        <h4>Recent Activity</h4>

        <table>
            <thead>
            <tr>
                <th>Date</th>
                <th>User</th>
                <th>Activity</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>01/04/2025</td>
                <td>john.smith@rtech.co.uk</td>
                <td>New installation booked</td>
            </tr>
            <tr>
                <td>31/03/2025</td>
                <td>sarah.jones@rtech.co.uk</td>
                <td>Customer consultation completed</td>
            </tr>
            <tr>
                <td>29/03/2025</td>
                <td>mike.davis@rtech.co.uk</td>
                <td>New staff member added</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>