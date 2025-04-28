<?php

// admin function to get error or success messages and output then, then clear them off
function admin_error(&$session){  // uses passes by reference no by value, so you can edit the session variable data properly

    if(isset($session['ERROR'])){  // checks for the session variable being set with an error
        $error = 'ERROR: '. $session['ERROR'];  //echos out the stored error from session
        unset($session['ERROR']);  //
        return $error;
    }
    elseif(isset($session['SUCCESS'])){  // checks for the session variable being set with an error
        $success = 'SUCCESS: '. $session['SUCCESS'];  //echos out the stored error from session
        unset($session['SUCCESS']);  //
        return $success;
    }
    else {
        return "";
    }
}


/*function sudo_check($conn){ //This code has been replaced by a piece of code tweaked by AI as i could not produce a working solution
    try {
        $sql = "select adm_type from admins where adm_type = '1'"; // pre define the SQL query to check for a specific entity
        $stmt = $conn->prepare($sql); // prepare statement for usage
        $stmt->execute(); // runs the statement
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC); // fetches result back
        if ($result){
            return true;
        } else{
            return false;
        }
}
catch(PDOException $e){ // catch the error as it occurs
        error_log("error in super_checker" . $e->getMessage());
        // throw an exception
    throw $e;
    }
}
*/

function sudo_check($conn){ // this is the code that has been tweaked by AI to rectify an issue i could not identify in  a timely manner
    try {
        $sql = "SELECT adm_type FROM admins WHERE adm_type = 'super'"; // pre define the SQL query to check for a specific entity
        $stmt = $conn->prepare($sql); // prepare statement for usage
        $stmt->execute(); // runs the statement

        // Actually fetch the results
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if any rows were returned
        if ($result) {
            return true; // Superuser exists
        } else {
            return false; // No superuser found
        }
    }
    catch(PDOException $e){ // catch the error as it occurs
        error_log("error in super_checker" . $e->getMessage());
        // throw an exception
        throw $e;
    }
}


function valid_email($email_address)
{
    $phrase = "@rtech.co.uk";
    if (strpos($email_address, $phrase) == false) {
        return false;
    } else {
        return true;
    }
}


function register_adm($conn, $post)
{
    if (!isset($post["email_address"], $post["password"])) {
        throw new Exception("email address or password cannot be empty");
    } elseif (valid_email($post["email_address"]) == false) {
        try { // SQL query prep
            $stmt = "INSERT INTO admins (email_address, password, adm_type) VALUES (?,?,?)"; // prep statement
            $stmt = $conn->prepare($stmt); // prep to send

// Correct PDO binding syntax
            $stmt->bindParam(1, $post["email_address"]);

// hash admin password
            $hpswd = password_hash($post["password"], PASSWORD_DEFAULT); // hashed here
            $stmt->bindParam(2, $hpswd);  //

            $admin_type = $post["priv"]; // pull the adm type
            $stmt->bindParam(3, $admin_type);
            $stmt->execute();
            $conn = null; // kill connection to avoid potential abuse
            return true; // reg successful

        } catch (PDOException $e) {
// to handle a database error
            error_log("Database error: " . $e->getMessage()); // to log the error
            throw new Exception("Database error: " . $e); // throw exception for calling script to handle
        } catch (Exception $e) {
            error_log("Registration Error : " . $e->getMessage());
            throw new Exception("Registration Error: " . $e->getMessage()); // throw exception for calling script to handle
        }
    } else {
        error_log("Email Incorrect Format"); // log error
        throw new Exception("Email Incorrect Format"); // exception for calling script to handle
    }
}

function reg_staff($conn, $post) {

    // Validate the post data
    if (!isset($post['email_address'], $post['password'])) {
        throw new Exception("Missing required fields.");
    } else{
        try {
            // Prepare and execute the SQL query
            $sql = "INSERT INTO staff (email_address, password, fname, sname,specialty) VALUES (?, ?, ?, ?, ?)";  //prepare the sql to be sent
            $stmt = $conn->prepare($sql); //prepare to sql


            $stmt->bindParam(1,($_POST['email_address']));  //bind parameters for security
            // Hash the password
            $hpswd = password_hash($post['password'], PASSWORD_DEFAULT);  //has the password
            $stmt->bindParam(2, $hpswd);
            $stmt->bindParam(3, $post['fname']);  //bind parameters for security
            $stmt->bindParam(4, $post['sname']);  //bind parameters for security
            $stmt->bindParam(5, $post['role']);  //bind parameters for security


            $stmt->execute();  //run the query to insert
            $conn = null;  // closes the connection so cant be abused.
            return true; // Registration successful
        }  catch (PDOException $e) {
            // Handle database errors
            error_log("Database error: " . $e->getMessage()); // Log the error
            throw new Exception("Database error". $e); //Throw exception for calling script to handle.
        } catch (Exception $e) {
            // Handle validation or other errors
            error_log("Registration error: " . $e->getMessage()); //Log the error
            throw new Exception("Registration error: " . $e->getMessage()); //Throw exception for calling script to handle.
        }
    }
}
