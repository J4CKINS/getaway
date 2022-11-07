<?php session_start(); ?>
<?php
function customerLoggedIn() {
    if(isset($_SESSION["customerID"])) {
        return true;
    }
    return false;
}

function adminLoggedIn() {
    if(isset($_SESSION["adminID"])) {
        return true;
    }
    return false;
}
?>