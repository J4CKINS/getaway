<?php
include __DIR__ . "/includes/session.php";
unset($_SESSION["customerID"]);
header("Location: /");
?>