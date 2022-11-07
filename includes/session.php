<?php session_start(); ?>
<?php
function customerLoggedIn() {
    if(isset($_SESSION["customerID"])) {
        return true;
    }
    return false;
}
?>