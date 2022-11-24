<?php
include __DIR__ . "/../../includes/mysql_tools.php";
include __DIR__ . "/../../includes/auth_admin.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (authAdmin()) {
        if (isset($_POST["hotelID"]) and hotelExists($_POST["hotelID"])) {

            // Clear the hotel gallery
            $uploadsFolderPath = __DIR__ . "/../..";
            $imageFiles = fetchHotelImages($_POST["hotelID"]);
            
            // Delete all hotel revires
            clearHotelReviews($_POST["hotelID"]);

            // Remove gallery entries from database
            clearHotelGallery($_POST["hotelID"]);
            
            // Delete image files
            foreach($imageFiles as $image) {
            unlink($uploadsFolderPath . $image["ImageURL"]);
            }

            deleteHotel($_POST["hotelID"]); // Remove hotel from database

            header("Location: /admin/hotels/");
            return;
        }
    }
} else {
    header("Location: /admin/hotels/");
    return;
}
?>