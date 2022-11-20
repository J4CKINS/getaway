<?php
include __DIR__ . "/../../includes/mysql_tools.php";
include __DIR__ . "/../../includes/auth_admin.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (authAdmin()) {
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