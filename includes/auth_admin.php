<?php
require_once(__DIR__ . "/session.php");
require_once(__DIR__ . "/mysql_tools.php");

function authAdmin() {
    if(isset($_SESSION["adminID"])) {
        if(adminAccountExists($_SESSION["adminID"])) {
            return true;
        }
    }

    return false;
}
?>