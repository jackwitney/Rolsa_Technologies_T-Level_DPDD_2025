<?php

echo "<div id='admin_navbar'>";
echo " :: ";

echo "<a href='../dashboard.php'> Home </a>";

echo " :: ";

if (!isset($_SESSION["admin_ssnlogin"])) {
    echo "<a href='admin_login.php'> Login </a>";
} else {
//    if super
    if ($_SESSION["adm_type"] === "super") {
        echo "<a href='admin_add.php'> Add admin </a>";
        echo " :: ";
    }
        if ($_SESSION["adm_type"] === "admin") {
            echo "<a href='add_staff.php'> Add Staff </a>";
            echo " :: ";
            echo "<a href='update_staff.php'> Update Staff Details</a>";
            echo " :: ";
        }
            if ($_SESSION["adm_type"] != "priv user") {
                echo "<a href='add_booking.php'> Add Booking </a>";
                echo " :: ";
            }

    }
// everyone
    echo "<a href='admin_logout.php'> Logout </a>";
    echo " :: ";
    echo "</div>";