<?php include __DIR__ . "//includes//mysql_tools.php" ?>
<!DOCTYPE html>
<html lang="en-GB">
    <head>
        <title>Getaway - Signup</title>
        <?php include __DIR__ . "\\templates\\head.php" ?>
        <link rel="stylesheet" type="text/css" href="/static/css/signup.css">
    <body>
        <div class="container">
        <?php include __DIR__ . "\\templates\\nav.php" ?>
        <div class="form-container">
           <form action="/signup.php" method="post">
                <h2>Create Account</h2>
                <input type="text" name="first_name" placeholder="First name" maxlength="255" required/>
                <input type="text" name="last_name" placeholder="Last name" maxlength="255" required/>
                <input type="email"name="email" placeholder="Email" maxlength="255" required/>
                <input type="tel" name="phone_number" placeholder="Phone number" maxlength="255" required/>
                <input type="password" name="password" placeholder="Password" maxlength="255" required/>
                <input type="submit" value="Sign-up" class="button"/>
                <p>Already have an account? <a href="/login.php">Login</a></p>
                <?php
                // Error message
                if(isset($_GET["error"])) {
                    echo "<p class=\"error\">" . $_GET["error"] . "</p>";
                }
                ?>
           </form>
        </div>
        <?php include __DIR__ . "\\templates\\footer.php" ?>
        </div>
    </body>
</html>

<?php

function error($message) {
    $encodedMessage = urlencode($message);
    header("Location: /signup.php?error=$encodedMessage");
    return;
}

// Check if page recieved a post request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //Form data
    $firstName      = $_POST["first_name"];
    $lastName       = $_POST["last_name"];
    $email          = $_POST["email"];
    $phoneNumber    = $_POST["phone_number"];
    $password       = $_POST["password"];

    $conn = database_connect();
    
    // Check if database has connected
    if (!$conn) {
        die("ERROR: Failed to connect to database");
        return;
    }

    // Check if phone number or email already exist
    $query = "SELECT `Email`, `PhoneNumber` FROM `Customer` WHERE `Email` = '$email' OR `PhoneNumber` = '$phoneNumber'";
    $results = $conn->query($query);
    
    // Check if an error has occured
    if (!$results) {
        die("ERROR: An SQL error has occured");
        return;
    }

    if ($results->num_rows > 0) {
        if ($results->fetch_assoc()["Email"] === $email) {
            error("Sorry, this email is already in use");
            return;
        } else {
            error("Sorry, this phone number is already in use");
            return;
        }
    }

    //Check password is atleast 8 characters long
    if(strlen($password) < 8) {
        error("Password must contain atleast 8 characters.");
        return;
    }

    //Save details to database
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO `Customer` ";
    $query .= "(`FirstName`, `LastName`, `Email`, `PhoneNumber`, `AccountPassword`) ";
    $query .= "VALUES ('$firstName', '$lastName', '$email', '$phoneNumber', '$hashedPassword');";

    if ($conn->query($query)) {
        header("Location: /login.php");
    }
}
?>