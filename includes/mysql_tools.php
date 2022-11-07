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
        $conn->close();
        
        // Return null if no results are found
        if ($results->num_rows < 1) { return null; }

        return $results->fetch_assoc();
    }

    // Search by Email
    elseif ($email) {
        $query = "SELECT * FROM `Customer` WHERE `Email` = '$email';";
        $results = $conn->query($query);
        $conn->close();

        // Return null if no results are found
        if ($results->num_rows < 1) { return null; }

        return $results->fetch_assoc();
    }
    return null;
}

function deleteCustomerAccount($ID) {
    $conn = database_connect();

    $query = "DELETE FROM `Customer` WHERE `ID` = $ID;";
    $conn->query($query);
    $conn->close();
}

function customerAccountExists($ID) {
    $conn = database_connect();
    $query = "SELECT `ID` FROM `Customer` WHERE `ID` = $ID;";
    $results = $conn->query($query);
    $conn->close();
    
    if ($results->num_rows > 0) {
        return true;
    }
    return false;
}


function fetchAdminData($ID = null, $email = null) {
    $conn = database_connect(); // Connect to the database
    
    // Search by ID
    if ($ID) {
        $query = "SELECT * FROM `Admin` WHERE `ID` = $ID;";
        $results = $conn->query($query);
        $conn->close();
        // Return null if no results are found
        if ($results->num_rows < 1) { return null; }

        return $results->fetch_assoc();
    }

    // Search by Email
    elseif ($email) {
        $query = "SELECT * FROM `Admin` WHERE `Email` = '$email';";
        $results = $conn->query($query);
        $conn->close();
        // Return null if no results are found
        if ($results->num_rows < 1) { return null; }

        return $results->fetch_assoc();
    }
    return null;
}

function adminAccountExists($ID) {
    $conn = database_connect();
    $query = "SELECT `ID` FROM `Admin` WHERE `ID` = $ID;";
    $results = $conn->query($query);
    $conn->close();

    if ($results->num_rows > 0) {
        return true;
    }
    return false;
}


function fetchAllHotels() {
    $conn = database_connect();
    $query = "SELECT * FROM `Hotel`;";;
    $results = $conn->query($query);
    $conn->close();

    if ($results->num_rows < 1) {
        return null;
    }
    return $results->fetch_all(MYSQLI_ASSOC);
}

function fetchHotelData($ID) {
    $conn = database_connect();
    $query = "SELECT * FROM `Hotel` WHERE `ID` = $ID;";
    $results = $conn->query($query);
    $conn->close();
    
    if ($results->num_rows < 1) {
        return null;
    }
    return $results->fetch_assoc();
}

function hotelExists($ID) {
    $conn = database_connect();
    $query = "SELECT `ID` FROM `Hotel` WHERE `ID` = $ID;";
    $results = $conn->query($query);
    $conn->close();
    
    if ($results->num_rows > 0) {
        return true;
    }
    return false;
}

function createHotel($hotelName, $hotelDescription, $contactNumber, $contactEmail, $streetAddress, $city, $postCode, $country, $price, $availableRooms) {
    $conn = database_connect();
    $query = "INSERT INTO `Hotel` ";
    $query .= "(`HotelName`, `HotelDescription`, `ContactNumber`, `ContactEmail`, `StreetAddress`, `City`, `Postcode`, `Country`, `Price`, `AvailableRooms`) ";
    $query .= "VALUES ('$hotelName', '$hotelDescription', '$contactNumber', '$contactEmail', '$streetAddress', '$city', '$postCode', '$country', '$price', '$availableRooms');";

    $conn->query($query);
    $conn->close();
}

function updateHotel($ID, $hotelName, $hotelDescription, $contactNumber, $contactEmail, $streetAddress, $city, $postCode, $country, $price, $availableRooms) {
    $conn = database_connect();
    $query = "UPDATE `Hotel` SET ";
    $query .= "`HotelName` = '$hotelName', ";
    $query .= "`HotelDescription` = '$hotelDescription', ";
    $query .= "`ContactNumber` = '$contactNumber', ";
    $query .= "`ContactEmail` = '$contactEmail', ";
    $query .= "`StreetAddress` = '$streetAddress', ";
    $query .= "`City` = '$city', ";
    $query .= "`Postcode` = '$postCode', ";
    $query .= "`Country` = '$country', ";
    $query .= "`Price` = $price, ";
    $query .= "`AvailableRooms` = $availableRooms ";
    $query .= "WHERE `ID` = $ID";

    $conn->query($query);
    $conn->close();
}

function deleteHotel($ID) {
    $conn = database_connect();
    $query = "DELETE FROM `Hotel` WHERE `ID` = $ID;";
    $conn->query($query);
    $conn->close();
}
?>