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

// GALLERY FUNCTIONS

function imageExists($imageID) {
    $conn = database_connect();
    $query = "SELECT `ID` FROM `Gallery` WHERE `ID` = $imageID;";
    $results = $conn->query($query);
    $conn->close();

    if ($results->num_rows > 0) {
        return true;
    }
    return false;
}

function fetchTotalHotelImages($hotelID) {
    $conn = database_connect();
    $query = "SELECT COUNT(`ID`) FROM `Gallery` WHERE `HotelID` = $hotelID;";
    $result = $conn->query($query);
    $total = $result->fetch_column(0);
    $conn->close();
    return $total;
}

function fetchHotelImages($hotelID) {
    $conn = database_connect();
    $query = "SELECT * FROM `Gallery` WHERE `HotelID` = $hotelID;";
    $results = $conn->query($query);
    $conn->close();
    return $results->fetch_all(MYSQLI_ASSOC);
}

function fetchImage($imageID) {
    $conn = database_connect();
    $query = "SELECT * FROM `Gallery` WHERE `ID` = $imageID;";
    $results = $conn->query($query);
    $conn->close();
    return $results->fetch_assoc();
}

function uploadImage($hotelID, $imageURL) {
    $conn = database_connect();
    $query = "INSERT INTO `Gallery` ";
    $query .= "(`HotelID`, `ImageURL`, `PrimaryImage`) ";
    $query .= "VALUES($hotelID, '$imageURL', 0);";
    $conn->query($query);
    $conn->close();
}

function deleteImage($imageID) {
    $conn = database_connect();
    $query = "DELETE FROM `Gallery` WHERE `ID` = $imageID;";
    $conn->query($query);
    $conn->close();
}

function fetchHotelPrimaryImage($hotelID) {
    $conn = database_connect();
    $query = "SELECT * FROM `Gallery` WHERE `HotelID` = $hotelID AND `PrimaryImage` = 1;";
    $results = $conn->query($query);
    $conn->close();

    // If no primary image is set, return first hotel image
    if ($results->num_rows < 1) {
        
        // Fetch hotel images
        $images = fetchHotelImages($hotelID);

        // If there are no images found for the hotel
        // Return error image in mysqli_assoc type of array for the gallery
        if(count($images) < 1) {
            return [
                "ID" => 0,
                "HotelID" => $hotelID,
                "ImageURL" => "/static/img/no_hotel_images.png",
                "PrimaryImage" => 0
            ];
        }

        return $images[0]; // Return first image;
    }

    // Return primary image
    return $results->fetch_assoc();
}

function isPrimaryImage($imageID, $hotelID) {
    $conn = database_connect();
    $query = "SELECT `PrimaryImage` FROM `Gallery` WHERE `ID` = $imageID AND `HotelID` = $hotelID;";
    $results = $conn->query($query);
    $primaryImage = $results->fetch_column(0);

    if ($primaryImage == 1) {
        return true;
    }
    return false;
}

function setPrimaryImage($imageID, $hotelID) {
    $conn = database_connect();

    // Set all images in hotel gallery to not primary
    // This ensures that there aren't 2 primary images
    $query = "UPDATE `Gallery` SET `PrimaryImage` = 0 WHERE `HotelID` = $hotelID;";
    $conn->query($query);

    // Set selected image to primary image
    $query = "UPDATE `Gallery` SET `PrimaryImage` = 1 WHERE `ID` = $imageID;";
    $conn->query($query);

    $conn->close();
}


// SUPPORT REQUEST FUNCTIONS

function submitSupportRequest($customerEmail, $requestSubject, $requestMessage) {
    $conn = database_connect();
    
    $query = "INSERT INTO `SupportRequest` ";
    $query .= "(`Email`, `RequestSubject`, `RequestMessage`) ";
    $query .= "VALUES ('$customerEmail', '$requestSubject', '$requestMessage');";

    $conn->query($query);
    $conn->close();
}

function supportRequestExists($ID) {
    $conn = database_connect();

    $query = "SELECT * FROM `SupportRequest` WHERE `ID` = $ID;";

    $results = $conn->query($query);
    $conn->close();

    if ($results->num_rows > 0) {
        return true;
    }
    return false;
}

function fetchAllSupportRequests($resolved=null) {
    $conn = database_connect();

    $query = "SELECT * FROM `SupportRequest`";

    // Fetch only resolved support requests
    if ($resolved === true) {
        $query .= " WHERE `Resolved` = 1";
    }
    // Fetch only unresolved support requests
    elseif ($resolved === false) {
        $query .= " WHERE `Resolved` = 0";
    }
    $query .= " ORDER BY `ID` DESC;";

    $results = $conn->query($query);
    $conn->close();
    return $results->fetch_all(MYSQLI_ASSOC);
}

function fetchSupportRequest($ID) {
    $conn = database_connect();
    
    $query = "SELECT * FROM `SupportRequest` WHERE `ID` = $ID;";
    $results = $conn->query($query);
    $conn->close();

    return $results->fetch_assoc();
}

function fetchSupportRequestsByEmail($email) {
    $conn = database_connect();

    $query = "SELECT * FROM `SupportRequest` WHERE `Email` = '$email';";
    $results = $conn->query($query);
    $conn->close();

    return $results->fetch_all(MYSQLI_ASSOC);
}
?>