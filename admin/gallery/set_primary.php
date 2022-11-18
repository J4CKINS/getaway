<?php 
include __DIR__ . "/../../includes/session.php";
include __DIR__ . "/../../includes/mysql_tools.php";
include __DIR__ . "/../../includes/auth_admin.php";

if(!authAdmin()) {
    header("Location: /admin/login.php");
    return;
}

if($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $hotelID = $_POST["hotelID"];
    $imageID = $_POST["imageID"];

    // Check for record existance
    if(!hotelExists($hotelID)) {
        echo "ERROR: Hotel doesn't exist";
        return;
    }

    if (!imageExists($imageID)) {
        echo "ERROR: Image doesn't exist";
        return;
    }

    setPrimaryImage($imageID, $hotelID);
    
    header("Location: /admin/gallery/edit.php?hotel=".$hotelID);
}
?>