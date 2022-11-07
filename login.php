<?php 
include __DIR__ . "/includes/mysql_tools.php";
include __DIR__ . "/includes/session.php";
?>
<!DOCTYPE html>
<html lang="en-GB">
    <head>
        <title>Getaway - Login</title>
        <?php include __DIR__ . "/templates/head.php" ?>
        <link rel="stylesheet" type="text/css" href="/static/css/login.css">
    </head>
    <body>
        <div class="container">
            <?php include __DIR__ . "/templates/nav.php" ?>
            <div class="form-container">
                <form action="/login.php" method="post">
                    <h2>Login</h2>
                    <input type="text" name="email" placeholder="Email" required/>
                    <input type="password" name="password" placeholder="Password" required/>
                    <input type="submit" class="button"/>
                    <p>Don't have an account?<a href="/signup.php">Sign up</a></p>
                    <?php
                    // Error message
                    if(isset($_GET["error"])) {
                        echo "<p class=\"error\">" . $_GET["error"] . "</p>";
                    }
                    ?>
                </form>
            </div>
            <?php include __DIR__ . "/templates/footer.php" ?>
        </div>
    </body>
</html>
<?php
function error($message) {
    $encodedMessage = urlencode($message);
    header("Location: /login.php?error=$encodedMessage");
    return;
}

// Check if page recieved a post request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Form data
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Fetch account from database
    $conn = database_connect();
    $query = "SELECT `ID`, `AccountPassword` FROM `Customer` WHERE `Email` = '$email';";
    $results = $conn->query($query);
    
    // Check if any results were found
    if ($results->num_rows < 1) {
        error("Email or password is incorrect.");
        return;
    }

    $accountData = $results->fetch_array();
    
    // Check if password matches
    if (!password_verify($password,$accountData[1])) {
        error("Email or password is incorrect.");
        return;
    }

    // Add user ID to the session
    $_SESSION["customerID"] = $accountData[0];
    header("Location: /");
}
?>