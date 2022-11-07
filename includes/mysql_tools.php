<?php
function database_connect() {
    $conn = new mysqli(
        "localhost",
        "getaway_app",
        "password",
        "getaway"
    );

    if ($conn->connect_error) {
        return null;
    }
    return $conn;
}

function fetchCustomerData($ID=null, $email=null) {
    $conn = database_connect(); // Connect to the database
    
    // Search by ID
    if ($ID) {
        $query = "SELECT * FROM `Customer` WHERE `ID` = $ID;";
        $results = $conn->query($query);
        
        // Return null if no results are found
        if ($results->num_rows < 1) { return null; }

        return $results->fetch_assoc();
    }

    // Search by Email
    elseif ($email) {
        $query = "SELECT * FROM `Customer` WHERE `Email` = '$email';";
        $results = $conn->query($query);

        // Return null if no results are found
        if ($results->num_rows < 1) { return null; }

        return $results->fetch_assoc();
    }
}  
?>