<?php
include __DIR__ . "/../../includes/mysql_tools.php";
include __DIR__ . "/../../includes/auth_admin.php";

if(!authAdmin()) {
    header("Location: /admin/login.php");
    return;
}

if($_SERVER["REQUEST_METHOD"] === "POST") {
    if(!isset($_POST["requestID"]) or !isset($_POST["resolved"])) {
        echo "ERROR: Required params have not been specified";
        return;
    }

    if(!supportRequestExists($_POST["requestID"])) {
        echo "ERROR: Support request does not exist";
        return;
    }

    if($_POST["resolved"] == 1) {
        unresolveSupportRequest($_POST["requestID"]);
    } else {
        resolveSupportRequest($_POST["requestID"]);
    }

    header("Location: /admin/support/request.php?requestID=" . $_POST["requestID"]);
    return;
}
?>