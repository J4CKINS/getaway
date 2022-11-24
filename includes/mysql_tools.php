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
        $query = "SELECT * FROM `Customer` WHERE `ID` = ?;";
        $query = $conn->prepare($query);
        $query->bind_param("i", $ID);
        $query->execute();
        $results = $query->get_result();
        $conn->close();
        
        // Return null if no results are found
        if ($results->num_rows < 1) { return null; }

        return $results->fetch_assoc();
    }

    // Search by Email
    elseif ($email) {
        $query = "SELECT * FROM `Customer` WHERE `Email` = ?;";
        $query = $conn->prepare($query);
        $query->bind_param("s", $email);
        $query->execute();
        $results = $query->get_result();
        $conn->close();

        // Return null if no results are found
        if ($results->num_rows < 1) { return null; }

        return $results->fetch_assoc();
    }
    return null;
}

function deleteCustomerAccount($ID) {
    $conn = database_connect();

    $query = "DELETE FROM `Customer` WHERE `ID` = ?;";
    $query = $conn->prepare($query);
    $query->bind_param("i", $ID);
    $query->execute();
    $conn->close();
}

function customerAccountExists($ID) {
    $conn = database_connect();
    $query = "SELECT `ID` FROM `Customer` WHERE `ID` = ?;";
    $query = $conn->prepare($query);
    $query->bind_param("i", $ID);
    $query->execute();
    $results = $query->get_result();
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
        $query = "SELECT * FROM `Admin` WHERE `ID` = ?;";
        $query = $conn->prepare($query);
        $query->bind_param("i", $ID);
        $query->execute();
        $results = $query->get_result();
        $conn->close();
        // Return null if no results are found
        if ($results->num_rows < 1) { return null; }

        return $results->fetch_assoc();
    }

    // Search by Email
    elseif ($email) {
        $query = "SELECT * FROM `Admin` WHERE `Email` = ?;";
        $query = $conn->prepare($query);
        $query->bind_param("s", $email);
        $query->execute();
        $results = $query->get_result();
        $conn->close();
        // Return null if no results are found
        if ($results->num_rows < 1) { return null; }

        return $results->fetch_assoc();
    }
    return null;
}

function adminAccountExists($ID) {
    $conn = database_connect();
    $query = "SELECT `ID` FROM `Admin` WHERE `ID` = ?;";
    $query = $conn->prepare($query);
    $query->bind_param("i", $ID);
    $query->execute();
    $results = $query->get_result();
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
    $query = "SELECT * FROM `Hotel` WHERE `ID` = ?;";
    $query = $conn->prepare($query);
    $query->bind_param("i", $ID);
    $query->execute();
    $results = $query->get_result();
    $conn->close();
    
    if ($results->num_rows < 1) {
        return null;
    }
    return $results->fetch_assoc();
}

function hotelExists($ID) {
    $conn = database_connect();
    $query = "SELECT `ID` FROM `Hotel` WHERE `ID` = ?;";
    $query = $conn->prepare($query);
    $query->bind_param("i", $ID);
    $query->execute();
    $results = $query->get_result();
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
    $query .= "VALUES (?,?,?,?,?,?,?,?,?,?);";

    $query = $conn->prepare($query);
    $query->bind_param("ssssssssdi", $hotelName, $hotelDescription, $contactNumber, $contactEmail, $streetAddress, $city, $postCode, $country, $price, $availableRooms);

    $query->execute();
    $conn->close();
}

function updateHotel($ID, $hotelName, $hotelDescription, $contactNumber, $contactEmail, $streetAddress, $city, $postCode, $country, $price, $availableRooms) {
    $conn = database_connect();
    $query = "UPDATE `Hotel` SET ";
    $query .= "`HotelName`= ?, ";
    $query .= "`HotelDescription`= ?, ";
    $query .= "`ContactNumber`= ?, ";
    $query .= "`ContactEmail`= ?, ";
    $query .= "`StreetAddress`= ?, ";
    $query .= "`City`= ?, ";
    $query .= "`Postcode`= ?, ";
    $query .= "`Country`= ?, ";
    $query .= "`Price`= ?, ";
    $query .= "`AvailableRooms`= ? ";
    $query .= "WHERE `ID`= ?;";

    $query = $conn->prepare($query);
    $query->bind_param("ssssssssdii", $hotelName, $hotelDescription, $contactNumber, $contactEmail, $streetAddress, $city, $postCode, $country, $price, $availableRooms, $ID);
    $query->execute();
    $conn->close();
}

function deleteHotel($ID) {
    $conn = database_connect();
    $query = "DELETE FROM `Hotel` WHERE `ID` = ?;";
    $query = $conn->prepare($query);
    $query->bind_param("i", $ID);
    $query->execute();
    $conn->close();
}

// GALLERY FUNCTIONS

function imageExists($imageID) {
    $conn = database_connect();
    $query = "SELECT `ID` FROM `Gallery` WHERE `ID` = ?;";
    $query = $conn->prepare($query);
    $query->bind_param("i", $imageID);
    $query->execute();
    $results = $query->get_result();
    $conn->close();

    if ($results->num_rows > 0) {
        return true;
    }
    return false;
}

function fetchTotalHotelImages($hotelID) {
    $conn = database_connect();
    $query = "SELECT COUNT(`ID`) FROM `Gallery` WHERE `HotelID` = ?;";
    $query = $conn->prepare($query);
    $query->bind_param("i", $hotelID);
    $query->execute();
    $result = $query->get_result();
    $total = $result->fetch_column(0);
    $conn->close();
    return $total;
}

function fetchHotelImages($hotelID) {
    $conn = database_connect();
    $query = "SELECT * FROM `Gallery` WHERE `HotelID` = ?";
    $query = $conn->prepare($query);
    $query->bind_param("i", $hotelID);
    $query->execute();
    $results = $query->get_result();
    $conn->close();
    return $results->fetch_all(MYSQLI_ASSOC);
}

function fetchImage($imageID) {
    $conn = database_connect();
    $query = "SELECT * FROM `Gallery` WHERE `ID` = ?;";
    $query = $conn->prepare($query);
    $query->bind_param("i", $imageID);
    $query->execute();
    $results = $query->get_result();
    $conn->close();
    return $results->fetch_assoc();
}

function uploadImage($hotelID, $imageURL) {
    $conn = database_connect();
    $query = "INSERT INTO `Gallery` ";
    $query .= "(`HotelID`, `ImageURL`, `PrimaryImage`) ";
    $query .= "VALUES(?, ?, 0);";
    $query = $conn->prepare($query);
    $query->bind_param("is", $hotelID, $imageURL);
    $query->execute();
    $conn->close();
}

function deleteImage($imageID) {
    $conn = database_connect();
    $query = "DELETE FROM `Gallery` WHERE `ID` = ?;";
    $query = $conn->prepare($query);
    $query->bind_param("i", $imageID);
    $query->execute();
    $conn->close();
}

function fetchHotelPrimaryImage($hotelID) {
    $conn = database_connect();
    $query = "SELECT * FROM `Gallery` WHERE `HotelID` = ? AND `PrimaryImage` = 1;";
    $query = $conn->prepare($query);
    $query->bind_param("i", $hotelID);
    $query->execute();
    $results = $query->get_result();
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
    $query = "SELECT `PrimaryImage` FROM `Gallery` WHERE `ID` = ? AND `HotelID` = ?;";
    $query = $conn->prepare($query);
    $query->bind_param("ii", $imageID, $hotelID);
    $query->execute();
    $results = $query->get_result();
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
    $query = "UPDATE `Gallery` SET `PrimaryImage` = 0 WHERE `HotelID` = ?;";
    $query = $conn->prepare($query);
    $query->bind_param("i", $hotelID);
    $query->execute();

    // Set selected image to primary image
    $query = "UPDATE `Gallery` SET `PrimaryImage` = 1 WHERE `ID` = ?;";
    $query = $conn->prepare($query);
    $query->bind_param("i", $imageID);
    $query->execute();

    $conn->close();
}

function clearHotelGallery($hotelID) {
    $conn = database_connect();

    $query = "DELETE FROM `Gallery` WHERE `HotelID` = ?";
    $query = $conn->prepare($query);
    $query->bind_param("i", $hotelID);
    $query->execute();

    $conn->close();
}

// SUPPORT REQUEST FUNCTIONS

function submitSupportRequest($customerEmail, $requestSubject, $requestMessage) {
    $conn = database_connect();
    
    $query = "INSERT INTO `SupportRequest` ";
    $query .= "(`Email`, `RequestSubject`, `RequestMessage`) ";
    $query .= "VALUES (?, ?, ?);";

    $query = $conn->prepare($query);
    $query->bind_param("sss", $customerEmail, $requestSubject, $requestMessage);
    $query->execute();

    $conn->close();
}

function supportRequestExists($ID) {
    $conn = database_connect();

    $query = "SELECT * FROM `SupportRequest` WHERE `ID` = ?";

    $query = $conn->prepare($query);
    $query->bind_param("i", $ID);
    $query->execute();
    $results = $query->get_result();

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
    
    $query = "SELECT * FROM `SupportRequest` WHERE `ID` = ?;";
    
    $query = $conn->prepare($query);
    $query->bind_param("i", $ID);
    $query->execute();
    $results = $query->get_result();

    $conn->close();

    return $results->fetch_assoc();
}

function fetchSupportRequestsByEmail($email) {
    $conn = database_connect();

    $query = "SELECT * FROM `SupportRequest` WHERE `Email` = ?;";
    
    $query = $conn->prepare($query);
    $query->bind_param("s", $email);
    $query->execute();
    $results = $query->get_result();

    $conn->close();

    return $results->fetch_all(MYSQLI_ASSOC);
}

function resolveSupportRequest($ID) {
    $conn = database_connect();

    $query = "UPDATE `SupportRequest` SET `Resolved` = 1 WHERE `ID` = ?;";
    
    $query = $conn->prepare($query);
    $query->bind_param("i", $ID);
    $query->execute();
    
    $conn->close();
}

function unresolveSupportRequest($ID) {
    $conn = database_connect();

    $query = "UPDATE `SupportRequest` SET `Resolved` = 0 WHERE `ID` = ?;";
    
    $query = $conn->prepare($query);
    $query->bind_param("i", $ID);
    $query->execute();

    $conn->close();
}

// Review Functions
function getHotelAvgRating($hotelID) {
    $conn = database_connect();
    $query = "SELECT AVG(`Rating`) FROM `Review` WHERE `HotelID` = ?;";
    
    $query = $conn->prepare($query);
    $query->bind_param("i", $hotelID);
    $query->execute();
    $result = $query->get_result();
    $conn->close();

    $result = $result->fetch_array()[0];

    if($result === null) {
        return 0;
    }

    return round($result);
}

function fetchHotelReviews($hotelID) {
    $conn = database_connect();
    $query = "SELECT `Review`.`Review`, `Review`.`Rating`, `Customer`.`FirstName`, `Customer`.`LastName` FROM `Review` INNER JOIN `Customer` ON `Review`.`CustomerID`=`Customer`.`ID` WHERE `HotelID` = ?;";

    $query = $conn->prepare($query);
    $query->bind_param("i", $hotelID);
    $query->execute();
    $results = $query->get_result();

    return $results->fetch_all(MYSQLI_ASSOC);
}

function createReview($customerID, $hotelID, $rating, $review) {
    $conn = database_connect();
    $query = "INSERT INTO `Review` (`CustomerID`, `HotelID`, `Rating`, `Review`) VALUES (?,?,?,?);";
    
    $query = $conn->prepare($query);
    $query->bind_param("iiis", $customerID, $hotelID, $rating, $review);
    $query->execute();

    $conn->close();
}

function clearCustomerReviews($customerID) {
    $conn = database_connect();

    $query = "DELETE FROM `Review` WHERE `CustomerID` = ?;";
    $query = $conn->prepare($query);
    $query->bind_param("i", $customerID);
    $query->execute();

    $conn->close();
}
?>