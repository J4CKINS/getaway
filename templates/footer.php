<?php require_once(__DIR__ . "/../includes/auth_customer.php"); ?>

<footer>
    <h3>Getaway</h3>
    <div id="links">
        <a href="/">Home</a>
        <a href="/hotels">Hotels</a>
        <a href="/support.php">Contact</a>
        <?php if(authCustomer()):?>
            <a href="/account">Account Information</a>
            <a href="/account/bookings/">View Bookings</a>
            <a href="/logout.php">Logout</a>
        <?php else: ?>
            <a href="/login.php">Login</a>
            <a href="/signup.php">Signup</a>
        <?php endif; ?>
    </div>
</footer>