<?php
include __DIR__ . "/../../includes/mysql_tools.php";
include __DIR__ . "/../../includes/auth_customer.php";

if($_SERVER["REQUEST_METHOD"] === "POST") {

    if(!authCustomer()) {
        header("Location: /login.php");
        return;
    }

    if(!isset($_POST["bookingID"])) {
        header("Location: /account/bookings/");
        return;
    }

    deleteBooking($_POST["bookingID"]);

    header("Location: /account/bookings/");
    return;
} else {
    header("Location: /account/bookings/");
    return;
}
?>