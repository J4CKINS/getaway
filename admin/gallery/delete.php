<?php
include __DIR__ . "/../../includes/mysql_tools.php";
include __DIR__ . "/../../includes/auth_admin.php";

// Auth admin
if (!authAdmin()) {
    header("Location: /admin/login.php");
    return;
}

if($_SERVER["REQUEST_METHOD"] === "POST") {

    if(!isset($_POST["imageID"])) {
        echo "Please specify the ID of the image you wish to delete";
        return;
    }

    if(!imageExists($_POST["imageID"])) {
        echo "ERROR: Image doesn't exist";
        return;
    }

    $imagePath = fetchImage($_POST["imageID"])["ImageURL"];

    // Delete the file
    unlink("/../.." . $imagePath);

    // Remove image from the database
    deleteImage($_POST["imageID"]);

    header("Location: /admin/gallery/edit.php?hotel=".$_POST["hotelID"]);
}
?>