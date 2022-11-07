<?
include __DIR__ . "/../includes/session.php";
include __DIR__ . "/../includes/mysql_tools.php";
?>
<!DOCTYPE html>
<html lang="en-GB">
    <head>
        <title>Getaway - Admin Login</title>
        <?php include __DIR__ . "/../templates/head.php"?>
        <link rel="stylesheet" type="text/css" href="/static/css/login.css">
    </head>
    <body>
        <div class="container">
            <?php include __DIR__ . "/../templates/nav.php" ?>
            <div class="form-container">
                <form method="post">
                    <h2>Login</h2>
                    <input type="text" name="email" placeholder="Email" requied/>
                    <input type="password" name="password" placeholder="Password" requied/>
                    <input type="submit" class="button"/>
                    <?php
                    if(isset($_GET["error"])) {
                        echo "<p class=\"error\">" . $_GET["error"] . "</p>";
                    }
                    ?>
                </form>
            </div>
            <?php include __DIR__ . "/../templates/footer.php" ?>
        </div>
    </body>
</html>
<?php
function error($message) {
    $encodedMessage = urlencode($message);
    header("Location: /admin/login.php?error=$encodedMessage");
    return;
}

// Check if page recieved a post request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Form data
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Fetch admin account data
    $accountData = fetchAdminData(email: $email);

    // Check if any results were found
    if ($accountData === null) {
        error("Email or password is incorrect.");
        return;
    }

    // Check if password matches
    if(!password_verify($password,$accountData["AccountPassword"])) {
        error("Email or password is incorrect.");
        return;
    }

    // Add admin ID to the session
    $_SESSION["adminID"] = $accountData["ID"];
    header("Location: /admin/");
}
?>