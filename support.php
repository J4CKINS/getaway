<?php
include __DIR__ . "/includes/session.php";
include __DIR__ . "/includes/mysql_tools.php";
include __DIR__ . "/includes/auth_customer.php";

if(!authCustomer()) {
    header("Location: /login.php");
    return;
}

$customerEmail = fetchCustomerData($_SESSION["customerID"])["Email"];

// Handle POST requests
if($_SERVER["REQUEST_METHOD"] === "POST") {
    submitSupportRequest(
        $_POST["email"],
        $_POST["message_subject"],
        $_POST["message"]
    );
    return;
}
?>
<!DOCTYPE html>
<html lang="en-GB">
    <head>
        <title>Getaway - Support</title>
        <?php include __DIR__ . "/templates/head.php" ?>
        <link rel="stylesheet" type="text/css" href="/static/css/support.css">
    </head>
    <body>
        <?php include __DIR__ . "/templates/nav.php"; ?>
        <div class="wrapper">
            <section>
                <h1>Contact Us</h1>
                <p><u>Logged in as: <?php echo $customerEmail; ?></u></p>
            </section>
            <section>
                <form method="POST">
                    <input type="hidden" name="email" value="<?php echo $customerEmail ?>"/>
                    <input type="text" name="message_subject" placeholder="Message Subject" maxlength="255" required/>
                    <textarea name="message" placeholder="Message" maxlength="2048" required></textarea>
                    <button type="submit">Submit</button>
                </form>
            </section>
        </div>
        <?php include __DIR__ . "/templates/footer.php"; ?>
    </body>
</html>