<?php
include __DIR__ . "/../includes/session.php";
include __DIR__ . "/../includes/mysql_tools.php";

// Redirect to login screen if user is not logged in
if (!customerLoggedIn()) { header("Location: /login.php"); }

// Fetch account data
$accountData = fetchCustomerData(ID: $_SESSION["customerID"]);
if ($accountData === null) { header("Location: /login.php"); return; } // Redirect to login page if account data could not be found
?>
<!DOCTYPE html>
<html lang="en-GB">
    <head>
        <title>Getaway - Account</title>
        <?php include __DIR__ . "/../templates/head.php" ?>
        <link rel="stylesheet" type="text/css" href="/static/css/account.css">
    </head>
    <body>
        <?php include __DIR__ . "/../templates/nav.php" ?>
        <div class="wrapper">
            <section>
                <h2>Account Information</h2>
                <table>
                    <tr>
                        <td>First Name</td>
                        <td><?php echo $accountData["FirstName"]?></td>
                    </tr>
                    <tr>
                        <td>Last Name</td>
                        <td><?php echo $accountData["LastName"]?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td><?php echo $accountData["Email"]?></td>
                    </tr>
                    <tr>
                        <td>Phone Number</td>
                        <td><?php echo $accountData["PhoneNumber"]?></td>
                    </tr>
                </table>
            </section>
            <section>
                <div class="controls">
                    <button type="button">View Bookings</button>
                    <form action="/../logout.php">
                    <button type="submit">Logout</button>
                    </form>
                    <form method="post">
                    <button type="submit" class="danger">Delete Account</button>
                    </form>
                </div>
            </section>
        </div>
        <?php include __DIR__ . "/../templates/footer.php" ?>
    </body>
</html>
<?php
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_SESSION["customerID"])) {
        deleteCustomerAccount($_SESSION["customerID"]);
        unset($_SESSION["customerID"]);
        header("Location: /");
    }
    return;
}
?>