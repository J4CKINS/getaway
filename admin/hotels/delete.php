<?php
include __DIR__ . "/../../includes/session.php";
include __DIR__ . "/../../includes/mysql_tools.php";

if (isset($_SERVER["REQUEST_METHOD"])) {
    if (adminLoggedIn() and adminAccountExists($_SESSION["adminID"])) {
        if (isset($_POST["hotelID"]) and hotelExists($_POST["hotelID"])) {
            deleteHotel($_POST["hotelID"]);
            header("Location: /admin/hotels/");
            return;
        }
    }
} else {
    header("Location: /admin/hotels/");
    return;
}
?>