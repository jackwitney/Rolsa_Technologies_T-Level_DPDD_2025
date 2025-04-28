<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Rolsa Technologies Dashboard</title>
</head>
<body>
<!-- Header -->
<header>
    <div class="logo">Rolsa Technologies Dashboard, [User]</div>
    <div class="header-buttons">
        <a href="book_appt.php"><button class="nav-btn">Book Appointment</button></a>
        <a href="calc.php"><button class="nav-btn">Carbon Calculator</button></a>
        <a href="contact_us.php"><button class="nav-btn">Contact Us</button></a>
        <a href="logout.php"><button class="nav-btn">Logout</button></a>
    </div>
    <img src="assets/Rolsa_Tech_Logo_Transparent.png" alt="Rolsa Logo" class="company-logo">
</header>

<!-- Main Content -->
<main>
    <!-- Appointments Section -->
    <div class="appointments-container">
        <!-- First Appointment Card -->
        <div class="appointment-card">
            <div class="appointment-details">
                <p><strong>Date:</strong> 15/03/2025</p>
                <p><strong>Type:</strong> Consultation</p>
            </div>
            <div class="appointment-notes">
                <p>Notes: Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc id ullamcorper lectus. Vivamus.</p>
            </div>
            <div class="appointment-actions">
                <button class="btn rearrange-btn">Rearrange</button>
                <button class="btn add-notes-btn">Add Notes</button>
                <button class="btn cancel-btn">Cancel</button>
            </div>
        </div>

        <!-- Second Appointment Card -->
        <div class="appointment-card">
            <div class="appointment-details">
                <p><strong>Date:</strong> 19/04/2025</p>
                <p><strong>Type:</strong> Installation</p>
            </div>
            <div class="appointment-notes">
                <p>Notes: Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc id ullamcorper lectus. Vivamus.</p>
            </div>
            <div class="appointment-actions">
                <button class="btn rearrange-btn">Rearrange</button>
                <button class="btn add-notes-btn">Add Notes</button>
                <button class="btn cancel-btn">Cancel</button>
            </div>
        </div>
    </div>

    <!-- Usage Stats Section -->
    <div class="usage-container">
        <div class="chart-container">
            <img src="assets/specific_uk_household.png" alt="Carbon Footprint Chart" class="chart-image">
        </div>

        <div class="usage-stats">
            <h2>Your Usage Rates this Year</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc id ullamcorper lectus. Vivamus consequat mauris sed diam porta pellentesque. Aenean eu urna laoreet, tempor risus ac, euismod lectus. Maecenas fermentum feugiat dolor, non finibus augue efficitur ut. Proin congue sem orci. Donec porttitor metus et elit lobortis, in eleifend massa mattis. Maecenas scelerisque fringilla massa ut viverra. Fusce ac mattis elit, nec congue erat. Nullam sit amet sollicitudin urna. Maecenas tristique faucibus lectus id aliquet. Aliquam rhoncus at justo sit amet luctus. Quisque imperdiet eleifend risus. Nulla eget sollicitudin velit. Suspendisse ultrices metus nibh, ut pulvinar purus dapibus ut.</p>
        </div>
    </div>
<br>

    <div class="usage-container">
        <div class="chart-container">
            <img src="assets/avg_household_footprint.png" alt="Carbon Footprint Chart" class="chart-image">
        </div>

        <div class="usage-stats">
            <h2>Household Average Usage Rates this Year</h2>
            <p>Nam malesuada in augue eu molestie. Integer scelerisque diam aliquet, auctor erat sit amet, gravida risus. Nunc quis dolor at felis posuere elementum. Fusce fermentum elit eu nisl ullamcorper, at aliquam arcu cursus. Mauris ac est sit amet sem ultrices sagittis sit amet consectetur eros. Mauris facilisis, libero eu efficitur imperdiet, enim risus consequat augue, non ornare erat odio in sem. Sed ligula erat, convallis vitae porttitor vitae, dignissim id nunc. Maecenas sollicitudin enim quis nulla eleifend condimentum. Aliquam finibus ante purus, sed luctus leo tempus at. Suspendisse vitae velit eget eros tempor ornare. Nulla ut nisl id libero euismod gravida. Praesent ut ligula efficitur, fermentum nibh id, laoreet ipsum. Maecenas eleifend lobortis enim, et fringilla quam sagittis eu. Duis vel aliquam mauris, ut lacinia est. Ut suscipit sapien eget faucibus euismod. Nulla in cursus metus.</p>
        </div>
    </div>
    <br>
    <div class="usage-container">
        <div class="chart-container">
            <img src="assets/uk_total_footprint.svg" alt="Carbon Footprint Chart" class="chart-image">
        </div>

        <div class="usage-stats">
            <h2>Uk wide Usage Rates this Year</h2>
            <p>Nam malesuada in augue eu molestie. Integer scelerisque diam aliquet, auctor erat sit amet, gravida risus. Nunc quis dolor at felis posuere elementum. Fusce fermentum elit eu nisl ullamcorper, at aliquam arcu cursus. Mauris ac est sit amet sem ultrices sagittis sit amet consectetur eros. Mauris facilisis, libero eu efficitur imperdiet, enim risus consequat augue, non ornare erat odio in sem. Sed ligula erat, convallis vitae porttitor vitae, dignissim id nunc. Maecenas sollicitudin enim quis nulla eleifend condimentum. Aliquam finibus ante purus, sed luctus leo tempus at. Suspendisse vitae velit eget eros tempor ornare. Nulla ut nisl id libero euismod gravida. Praesent ut ligula efficitur, fermentum nibh id, laoreet ipsum. Maecenas eleifend lobortis enim, et fringilla quam sagittis eu. Duis vel aliquam mauris, ut lacinia est. Ut suscipit sapien eget faucibus euismod. Nulla in cursus metus.</p>
        </div>
    </div>
</main>
</body>
</html>