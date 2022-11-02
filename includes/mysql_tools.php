<?php
function database_connect() {
    $conn = new mysqli(
        "localhost",
        "getaway_app",
        "password",
        "getaway"
    );

    if ($conn->connect_error) {
        return null;
    }
    return $conn;
}
?>