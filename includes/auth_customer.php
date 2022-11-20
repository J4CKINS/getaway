<?php
require_once(__DIR__ . "/session.php");
require_once(__DIR__ . "/mysql_tools.php");

function authCustomer() {
    if( isset($_SESSION["customerID"] ) ) {
        if (customerAccountExists($_SESSION["customerID"])) {
            return true;
        }
    } 
    return false;
}
?>