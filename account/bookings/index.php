<?php
include __DIR__ . "/../../includes/session.php";
include __DIR__ . "/../../includes/mysql_tools.php";
include __DIR__ . "/../../includes/auth_customer.php";

if(!authCustomer()) {
    header("Location: /login.php");
    return;
}

$upcomingBookings = fetchUpcomingBookings($_SESSION["customerID"]);
$previousBookings = fetchPreviousBookings($_SESSION["customerID"]);
?>
<!DOCTYPE html>
<html lang="en-GB">
    <head>
        <title>Getaway - Bookings</title>
        <?php include __DIR__ . "/../../templates/head.php"; ?>
        <link rel="stylesheet" type="text/css" href="/static/css/bookings.css">
    </head>
    <body>
        <?php include __DIR__ . "/../../templates/nav.php"; ?>
        <div class="wrapper">
            <section>
                <h2>Upcoming Bookings</h2>
                <?php if($upcomingBookings !== array()): ?>
                <div class="booking-list">
                    <?php foreach($upcomingBookings as $booking):?>
                        <div class="booking">
                            <div class="col-left">
                                <h3><?php echo $booking["HotelName"]; ?></h3>
                                <p><?php echo $booking["DateFrom"]; ?> &rarr; <?php echo $booking["DateTo"]; ?></p>
                                <p>Guests: <?php echo $booking["Guests"]; ?></p>
                            </div>
                            <div class="col-right">
                                <form action="cancel.php" method="POST">
                                    <input type="hidden" name="bookingID" value="<?php echo $booking["ID"]; ?>"/>
                                    <button type="submit">Cancel Booking</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                    <p>No Bookings Available</p>
                <?php endif; ?>
            </section>
            <section>
                <h2>Previous Bookings</h2>
                <?php if($previousBookings !== array()): ?>
                <div class="booking-list">
                    <?php foreach($previousBookings as $booking):?>
                        <div class="booking">
                            <div class="col-left">
                                <h3><?php echo $booking["HotelName"]; ?></h3>
                            </div>
                            <div class="col-right">
                                <p><?php echo $booking["DateFrom"]; ?> &rarr; <?php echo $booking["DateTo"]; ?></p>
                                <p>Guests: <?php echo $booking["Guests"]; ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                    <p>No Bookings Available</p>
                <?php endif; ?>
            </section>
        </div>
        <?php include __DIR__ . "/../../templates/footer.php"; ?>
    </body>
</html>