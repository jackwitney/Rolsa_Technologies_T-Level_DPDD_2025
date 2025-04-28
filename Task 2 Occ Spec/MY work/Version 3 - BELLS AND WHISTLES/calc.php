<?php
// Carbon Footprint Calculator - A simple tool to estimate personal carbon emissions

// Define emission factors for different sources of carbon
$factors = [
    'electricity' => 0.2,  // Conversion factor for electricity: 0.2 kg CO2 per kWh
    'gas' => 0.2,          // Conversion factor for natural gas: 0.2 kg CO2 per kWh
    'vehicle' => 0.15,     // Conversion factor for vehicle travel: 0.15 kg CO2 per mile
    'water' => 0.001,      // Conversion factor for water: 0.001 kg CO2 per liter
    'diet_meat' => 1500,   // Annual emissions for meat eater: 1500 kg CO2 per year
    'diet_veg' => 600      // Annual emissions for vegetarian: 600 kg CO2 per year
];

// Initialize variables to store calculation results and control page display
$carbon_total = 0;         // Will hold the total carbon footprint in kg
$show_results = false;     // Controls whether to show form or results

// Check if the form has been submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract input values from the form, defaulting to 0 if not provided
    $electricity = floatval($_POST['electricity'] ?? 0); // Electricity usage in kWh/year
    $gas = floatval($_POST['gas'] ?? 0);                 // Gas usage in kWh/year
    $vehicle = floatval($_POST['vehicle'] ?? 0);         // Vehicle distance in miles/year
    $water = floatval($_POST['water'] ?? 0);             // Water usage in liters/year
    $diet = $_POST['diet'] ?? 'meat';                    // Diet type selection

    // Calculate the carbon footprint by multiplying each input by its emission factor
    $carbon_total = ($electricity * $factors['electricity']) + // Electricity emissions
        ($gas * $factors['gas']) +                 // Gas emissions
        ($vehicle * $factors['vehicle']) +         // Vehicle emissions
        ($water * $factors['water']);              // Water emissions

    // Add the appropriate diet-based emissions to the total
    if ($diet == 'meat') {
        $carbon_total += $factors['diet_meat']; // Add meat diet emissions
    } else {
        $carbon_total += $factors['diet_veg'];  // Add vegetarian diet emissions
    }

    // Convert from kilograms to tonnes for easier display (1 tonne = 1000 kg)
    $carbon_tonnes = $carbon_total / 1000;

    // Set flag to display results instead of the form
    $show_results = true;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Carbon Footprint Calculator</title>
    <link rel="stylesheet" href="styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<!-- Navigation Bar -->
<header>
    <div class="logo">Rolsa Technologies Simple Carbon Calculator</div>
    <div class="header-buttons">
        <a href="dashboard.php"><button class="nav-btn">Dashboard</button></a>
        <a href="book_appt.php"><button class="nav-btn">Book Appointment</button></a>
        <a href="contact_us.php"><button class="nav-btn">Contact Us</button></a>
        <a href="logout.php"><button class="nav-btn">Logout</button></a>
    </div>
</header>

<main>
    <div id="container">
        <?php if (!$show_results): ?>
            <!-- Calculator Form -->
            <div id="content">
                <h2>Carbon Footprint Calculator</h2>

                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <!-- Home Energy Section -->
                    <div class="section">
                        <h4>Home Energy</h4>

                        <p class="input-help">The Average UK Household is classified as 2-3 inhabitants</p>
                        <div class="form-group">
                            <label for="electricity">Electricity (kWh per year)</label>
                            <input type="number" id="electricity" name="electricity" min="0" value="0">
                            <p class="input-help">Average UK household uses around 8 KW Hours per day (2,700 Kwh/year)</p>
                        </div>

                        <div class="form-group">
                            <label for="gas">Gas (kWh per year)</label>
                            <input type="number" id="gas" name="gas" min="0" value="0">
                            <p class="input-help">Average UK household uses around 33 KW Hours per day (11,500 Kwh/year)</p>
                        </div>

                        <div class="form-group">
                            <label for="water">Water (liters per year)</label>
                            <input type="number" id="water" name="water" min="0" value="0">
                            <p class="input-help">Average UK household uses around 350 liters per day (127,750 liters/year)</p>
                        </div>
                    </div>

                    <!-- Transportation Section -->
                    <div class="section">
                        <h4>Transportation</h4>

                        <div class="form-group">
                            <label for="vehicle">Motor vehicle travel (miles per year)</label>
                            <input type="number" id="vehicle" name="vehicle" min="0" value="0">
                            <p class="input-help">This includes all types of transport (car, bus, train, etc.)</p>
                        </div>
                    </div>

                    <!--section to select the diet of the user-->
                    <div class="section">
                        <h4>Diet</h4>

                        <div class="form-group">
                            <label for="diet">Your diet type</label>
                            <select id="diet" name="diet">
                                <option value="meat">Regular meat eater</option>
                                <option value="veg">Vegetarian/Vegan</option>
                            </select>
                        </div>
                    </div>
<!--This section contains the disclaimer information about the carbon footprint calculator and its current shortcomings-->
                    <div class="section">
                        <h4>Disclaimer</h4>
                        <p class="input-help">This carbon footprint calculator works on a simplified system where the emissions of cars, bikes and trains have
                            been combined into one factor. This is intended to be used as a guide to your carbon usage but is in no way a 100% accurate source, please
                            seek a specialist consultation to diagnose your true carbon footprint.</p>
                        <br>
                        <p class="input-help">
                            We have also not included factors related to shopping & fast fashion or your food wastage per year as we understand these factors are not
                            common knowledge whereas gas, water and electric usages can be monitored in the comfort of your own home using the Rolsa Technologies Smart
                            home systems.
                         </p>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="submit-btn">Calculate Footprint</button>
                    </div>
                </form>
            </div>

        <?php else: ?>
            <!-- Results Display -->
            <div id="content">
                <h2>Carbon Footprint Results</h2>

                <div class="section">
                    <div class="result-card">
                        <div class="result-title">Your Carbon Footprint</div>

                        <div class="result-value">
                            <?php echo number_format($carbon_tonnes, 2); ?> tonnes CO2 per year
                        </div>
<!--This is the if statement to compare carbon tonnage to the UK average and inform the user where they stand in terms of Usages-->
                        <?php
                        if ($carbon_tonnes < 5) {
                            echo '<div class="success-message">Your carbon footprint is low compared to average!</div>';
                        } elseif ($carbon_tonnes < 10) {
                            echo '<p>Your carbon footprint is about average.</p>';
                        } else {
                            echo '<div class="error-message">Your carbon footprint is higher than average.</div>';
                        }
                        ?>
                    </div>
                </div>
<!--This section contains the information on reducing carbon footprint-->
                <div class="section">
                    <h4>Simple Tips to Reduce Your Footprint</h4>
                    <ul class="tips-list">
                        <li>Use energy-efficient appliances</li>
                        <li>Reduce motor vehicle travel when possible</li>
                        <li>Consider eating less meat</li>
                        <li>Improve home insulation to reduce energy usage</li>
                        <li>Use water-saving fixtures like low-flow showerheads</li>
                        <li>Fix leaking taps to save water</li>
                        <li>Use renewable energy sources where possible</li>
                    </ul>
                </div>

                <div class="form-group">
                    <form method="get">
                        <button type="submit" class="submit-btn">Calculate Again</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>
</body>
</html>