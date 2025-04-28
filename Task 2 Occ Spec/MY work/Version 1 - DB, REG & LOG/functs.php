<?php

// function to compare 2 passwords to ensure they match
function pwrd_checker($password, $cpassword) {  //takes in 2 parameters

    if($password!=$cpassword){  // do the passwords not match
        return false; // return false
    }
    elseif(strlen($password)<8){  // is the password long enough?
        return false;
    }
    else{
        return true;
    }
}

function usr_error(){

    if(isset($_SESSION['ERROR'])){  // checks for the session variable being set with an error
        $error = 'ERROR: '. $_SESSION['ERROR'];  //echos out the stored error from session
        unset($_SESSION['ERROR']);  //
        return $error;
    }
    elseif(isset($_SESSION['SUCCESS'])){  // checks for the session variable being set with an error
        $success = 'SUCCESS: '. $_SESSION['SUCCESS'];  //echos out the stored error from session
        unset($_SESSION['SUCCESS']);  //
        return $success;
    }
    else {
        return "";
    }
}

function only_user($conn, $username){
    try {
        $sql = "SELECT email_address FROM users WHERE email_address = ?"; //set up the sql statement
        $stmt = $conn->prepare($sql); //prepares
        $stmt->bindParam(1, $username);
        $stmt->execute(); //run the sql code
        $result = $stmt->fetch(PDO::FETCH_ASSOC);  //brings back results
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    catch (PDOException $e) { //catch error
        // Log the error (crucial!)
        error_log("Database error in only_user: " . $e->getMessage());
        // Throw the exception
        throw $e; // Re-throw the exception
    }
}

function reg_user($conn,$post){
    if (!isset($post['email_address'], $post['password'], $post['fname'], $post['sname'])) {
        throw new Exception("Missing required fields.");
    } else{
        try {
            // Prepare and execute the SQL query
            $sql = "INSERT INTO users (email_address, password, fname, sname, addressln1, addressln2, city, postcode, phone) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";  //prepare the sql to be sent
            $stmt = $conn->prepare($sql); //prepare to sql

            $stmt->bindParam(1, $post['email_address']);  //bind parameters for security
            $hpswd = password_hash($post['password'], PASSWORD_DEFAULT);  //hash the password
            $stmt->bindParam(2, $hpswd);
            $stmt->bindParam(3, $post['fname']);  //bind parameters for security
            $stmt->bindParam(4, $post['sname']);  //bind parameters for security
            $stmt->bindParam(5, $post['addressln1']);  //bind parameters for security
            if(!isset($post['addressln2'])){
                $stmt->bindParam(5, " ");
            } else {
                $stmt->bindParam(6, $post['addressln2']);  //bind parameters for security
            }
            $stmt->bindParam(7, $post['city']);  //bind parameters for security
            $stmt->bindParam(8, $post['postcode']);  //bind parameters for security
            $stmt->bindParam(9, $post['phone']);  //bind parameters for security

            $stmt->execute();  //run the query to insert
            $conn = null;  // closes the connection so cant be abused.
            return true; // Registration successful
        }  catch (PDOException $e) {
            // Handle database errors
            error_log("User Reg Database error: " . $e->getMessage()); // Log the error
            throw new Exception("User Reg Database error". $e); //Throw exception for calling script to handle.
        } catch (Exception $e) {
            // Handle validation or other errors
            error_log("User Registration error: " . $e->getMessage()); //Log the error
            throw new Exception("User Registration error: " . $e->getMessage()); //Throw exception for calling script to handle.
        }
    }

}

function validlogin($conn, $email_address){

    $sql = "SELECT * FROM users WHERE email_address = ?"; //set up the sql statement
    $stmt = $conn->prepare($sql); //prepares
    $stmt->bindParam(1,$email_address);  //binds the parameters to execute
    $stmt->execute(); //run the sql code
    $result = $stmt->fetch(PDO::FETCH_ASSOC);  //brings back results
    $conn = null;  // nulls off the connection so cant be abused.

    if($result){  // if a user with this email is in there,
        return true;  // returns true to proceed
    } else {
        return false;  // otherwise, if no results, false and error message
    }

}

function pswdcheck($conn, $email_address_address){
    try {
        $sql = "SELECT password FROM users WHERE email_address = ?"; //set up the sql statement
        $stmt = $conn->prepare($sql); //prepares
        $stmt->bindParam(1, $email_address_address);
        $stmt->execute(); //run the sql code
        $result = $stmt->fetch(PDO::FETCH_ASSOC);  //brings back results
        $conn = null;  // securely close off the connection

        if(password_verify($_POST["password"], $result['password'])){
            return true;
        } else {
            return false;
        }

    }
    catch (PDOException $e) { //catch error
        // Log the error (crucial!)
        error_log("Database error in get_userid function: " . $e->getMessage());
        // Throw the exception
        throw $e; // Re-throw the exception
    }
}

function get_userid($conn,$post){  // new function to source the userID after registering then store it in the session data
    try {
        $sql = "SELECT user_id FROM users WHERE email_address = ?"; //set up the sql statement
        $stmt = $conn->prepare($sql); //prepares
        $stmt->bindParam(1, $post['email_address']);
        $stmt->execute(); //run the sql code
        $result = $stmt->fetch(PDO::FETCH_ASSOC);  //brings back results
        $conn = null;  // securely close off the connection
        return $result["user_id"];
    }
    catch (PDOException $e) { //catch error
        // Log the error (crucial!)
        error_log("Database error in get_userid function: " . $e->getMessage());
        // Throw the exception
        throw $e; // Re-throw the exception
    }
}

function get_time($choice){
    // date time local picker
    $current_epoch = time();

    if($choice != "current"){  // if they want to add a week to the time for date picker
        $current_epoch = time() + 604800;
    }
// Convert epoch to a DateTime object
    $datetime = new DateTime("@$current_epoch"); // The "@" symbol is crucial here to tell php its a unix time code
// Set the desired format for datetime-local
    $datetime_local_format = $datetime->format('Y-m-d\TH:i');

    return $datetime_local_format;  // return the date to be used
}

function get_appt_staff($conn){
    try {
        $sql = "SELECT staff_id, f_name, s_name, role FROM staff"; //set up the sql statement
        $stmt = $conn->prepare($sql); //prepares
        $stmt->execute(); //run the sql code
        return $stmt->fetchall(PDO::FETCH_ASSOC);  //brings back results

    }
    catch (PDOException $e) { //catch error
        // Log the error (crucial!)
        error_log("Database error in get ticket type: " . $e->getMessage());
        // Throw the exception
        throw $e; // Re-throw the exception
    }
}

function valid_staff($conn,$post){
    try {
        $sql = "SELECT * FROM staff WHERE staff_id = ?"; //set up the sql statement
        $stmt = $conn->prepare($sql); //prepares
        $stmt->bindParam(1, $post['staff_pick']);
        $stmt->execute(); //run the sql code
        $result = $stmt->fetch(PDO::FETCH_ASSOC);  //brings back results
        if($result['role']!=$post['apt_type']){ // checks staff role against the desired appointment type
            return false;
        } else {
            return true;
        }
    }
    catch (PDOException $e) { //catch error
        // Log the error (crucial!)
        error_log("Database error in get ticket type: " . $e->getMessage());
        // Throw the exception
        throw $e; // Re-throw the exception
    }

}

function valid_appointment($conn,$post){
    try {
        $sql = "SELECT * FROM booking WHERE staff_id = ?"; //set up the sql statement
        $stmt = $conn->prepare($sql); //prepares
        $stmt->bindParam(1, $post['staff_pick']);
        $stmt->execute(); //run the sql code
        $result = $stmt->fetchall(PDO::FETCH_ASSOC);  //brings back results
        $conn = null;
        if(!$result && in_working_week($post['meeting-time'])){  // if no current bookings for this staff
            return true;  // allow the booking to be made
        } elseif($result && in_working_week($post['meeting-time']) && booking_time_check($result,$post['meeting-time'])){
            echo "last check";
            return true;
        } else {
            return false;
        }
    }
    catch (PDOException $e) { //catch error
        // Log the error (crucial!)
        error_log("Database error in get ticket type: " . $e->getMessage());
        // Throw the exception
        throw $e; // Re-throw the exception
    }
}

function in_working_week($datetimeLocalValue) {
    // Convert datetime-local string to DateTime object
    $dateTime = DateTime::createFromFormat('Y-m-d\TH:i', $datetimeLocalValue);

    if (!$dateTime) {
        return false; // Invalid datetime format
    }

    // Check if it's a weekday (Monday = 1, Sunday = 7)
    $dayOfWeek = $dateTime->format('N');
    if ($dayOfWeek >= 6) { // Saturday or Sunday
        return false; // Not a weekday
    }

    // Get the date part
    $date = $dateTime->format('Y-m-d');

    // Create DateTime objects for 8 AM and 4 PM on the same date
    $startTime = new DateTime("$date 08:00:00");
    $endTime = new DateTime("$date 16:00:00");

    // Check if the given time is within the range
    if ($dateTime >= $startTime && $dateTime <= $endTime) {
        return true; // Within working hours on a weekday
    } else {
        return false; // Outside working hours
    }
}


function booking_time_check($existingBookings, $selectedtime) {

    $oneAndHalfHours = 5400; // 1.5 hours in seconds (90 minutes)

    foreach ($existingBookings as $existingBooking) {  // works through all of the bookings one at time
        $existingEpoch = $existingBooking['consult_date']; // collects each booking date / time

        // calcs the difference between the wanted and stored and if the time us less than 90 mins apart, cant use it
        if (abs($selectedtime - $existingEpoch) <= $oneAndHalfHours) {
            return false; // Conflict found
        }
    }
    return true; // No conflict found
}


function commit_booking($conn, $post){

    try {
        // Prepare and execute the SQL query
        $sql = "INSERT INTO booking (made_on, consult_date, user_id, staff_id, product) VALUES (?, ?, ?, ?, ?)";  //prepare the sql to be sent
        $stmt = $conn->prepare($sql); //prepare to sql

        // param 1 is the time right now, when it was made
        $right_now = time();
        $stmt->bindParam(1, $right_now);  //bind parameters for security

        // param 2 is taking the chosen time and making it epoch
        $dateTime = DateTime::createFromFormat('Y-m-d\TH:i', $post['meeting-time']);
        $epochTime = $dateTime->getTimestamp();
        $stmt->bindParam(2, $epochTime);  //bind parameters for security

        // param 3 is the userid taken from session data
        $stmt->bindParam(3, $_SESSION['user_id']);  //bind parameters for security

        // param 4 is the staff id doing the job, taken from post data
        $stmt->bindParam(4, $post['staff_pick']);  //bind parameters for security

        // param 5 is the product, from the form TO BE MADE - ADD THIS ASAP
        $stmt->bindValue(5, " Product should be in here, make a form element ");  //bind parameters for security

        $stmt->execute();  //run the query to insert
        $conn = null;  // closes the connection so cant be abused.
        return true; // Registration successful
    }  catch (PDOException $e) {
        // Handle database errors
        error_log("Make Booking error: " . $e->getMessage()); // Log the error
        throw new Exception("Make Booking error". $e); //Throw exception for calling script to handle.
    } catch (Exception $e) {
        // Handle validation or other errors
        error_log("Make Booking error: " . $e->getMessage()); //Log the error
        throw new Exception("Make Booking error: " . $e->getMessage()); //Throw exception for calling script to handle.
    }
}


// to be used in version 2 of booking system.
function appointment_timings($datetimeLocalValue, $epochTimes)
{
    // Convert datetime-local to DateTime object
    $dateTime = DateTime::createFromFormat('Y-m-d\TH:i', $datetimeLocalValue);
    if (!$dateTime) {
        return false; // Invalid datetime format
    }

    // Convert datetime-local to epoch time
    $localEpoch = $dateTime->getTimestamp();

    // Get the date component from the datetime-local input
    $localDate = $dateTime->format('Y-m-d');

    $oneHour = 3600; // 60 minutes in seconds

    foreach ($epochTimes as $epochTime) {
        // Convert epoch time to DateTime object
        $existingDateTime = new DateTime("@$epochTime");

        // Get the date component from the existing epoch time
        $existingDate = $existingDateTime->format('Y-m-d');

        // Check if they are on the same day
        if ($localDate === $existingDate) {
            // Check if they are less than 60 minutes apart
            if (abs($localEpoch - $epochTime) < $oneHour) {
                return false; // Less than 60 minutes apart
            }
        }
    }
}