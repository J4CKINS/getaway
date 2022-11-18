<?php
include __DIR__ . "/../../includes/session.php";
include __DIR__ . "/../../includes/mysql_tools.php";
include __DIR__ . "/../../includes/auth_admin.php";

$uploadsDir = "/uploads/"; // uploads dir from root
$relativeUploadsDir = __DIR__ . "/../../uploads/"; // Uploads dir path relative to this script

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Validate admin 
    if (!authAdmin()) {
        echo "User unauthorized";
        return;
    }

    // Hotel exists check
    if(!( isset($_POST["hotelID"]) and hotelExists($_POST["hotelID"]) )) {
        echo "Hotel does not exist";
        return;
    }

    // Check if uploads directory exists
    if(!is_dir($relativeUploadsDir)) {
        // Create uploads directory if it doesnt exist
        mkdir($relativeUploadsDir);
    }

    $file = $_FILES["image"];

    // Change file name to following format: {base64 encoded hotel name}_{unix time of upload}
    $fileExtention = "." . explode(".", basename($file["name"]))[1];
    $file["name"] = base64_encode($file["name"]) . "_" . time() . $fileExtention;

    $targetFile = $relativeUploadsDir . basename($file["name"]);

    // Check if image is in the correct format
    if( !in_array($file["type"], ["image/jpeg", "image/png"]) ) {
        echo "File format is not supported";
        return;
    }

    if(move_uploaded_file($file["tmp_name"], $targetFile)) {
        uploadImage($_POST["hotelID"], $uploadsDir . $file["name"]);
        header("Location: /admin/gallery/edit.php?hotel=".$_POST["hotelID"]);
        return;
    } else {
        echo("Failed to upload file");
    }
}
?>