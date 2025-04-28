<?php

echo "<div id='user_navbar'>";
echo " :: ";

echo "<a href='index.php'> Home </a>";

echo " :: ";

if (!isset($_SESSION["user_ssnlogin"])) {
    echo "<a href='login.php'> Login </a>";
    echo " :: ";
    echo "<a href='register.php'> Register </a>";
    echo " :: ";

} else {
//    if super

    echo "<a href='../admin_dashboard.php'> Book tickets </a>";
    echo " :: ";


}
// everyone
if (isset($_SESSION["user_ssnlogin"])) {
    echo "<a href='logout.php'> Logout </a>";
    echo " :: ";
}
echo "</div>";