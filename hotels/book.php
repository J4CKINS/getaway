<?php
include __DIR__ . "/../includes/session.php";
include __DIR__ . "/../includes/mysql_tools.php";
include __DIR__ . "/../includes/auth_customer.php";

if(!authCustomer()) {
    header("Location: /login.php");
    return;
}
?>
<?php if($_SERVER["REQUEST_METHOD"] === "GET"): ?>

<?php
    if(!isset($_GET["hotelID"])) {
        header("Location: /hotels/");
        return;
    }

    if(!hotelExists($_GET["hotelID"])) {
        header("Location: /hotels/");
        return;
    }

    $hotel = fetchHotelData($_GET["hotelID"]);
?>
<!DOCTYPE html>
<html lang="en-GB">
    <head>
        <title>Getaway - Book | <?php echo $hotel["HotelName"]; ?></title>
        <?php include __DIR__ . "/../templates/head.php"; ?>
        <link rel="stylesheet" type="text/css" href="/static/css/book.css">
    </head>
    <body>
        <?php include __DIR__ . "/../templates/nav.php"; ?>
        <div class="wrapper">
            <section>
                <img id="hotel-image" src="<?php echo fetchHotelPrimaryImage($hotel["ID"])["ImageURL"]; ?>"/>
                <h2><?php echo $hotel["HotelName"]; ?></h2>
            </section>
            <section>
                <h3>Booking Details</h3>
                <form method="post">
                    <input type="hidden" name="customerID" value="<?php echo $_SESSION["customerID"] ?>"/>
                    <input type="hidden" name="hotelID" value="<?php echo $hotel["ID"]; ?>"/>
                    <select name="guests" required>
                        <option value="" disabled selected hidden>Number of Guests</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                    </select>
                    <label for="date-from">Booking Start</label>
                    <input type="date" name="datefrom" id="date-from" required/>
                    <label for="date-to">Booking End</label>
                    <input type="date" name="dateto" id="date-to" required/>
                    <button type="submit">Book</button>
                </form>
                <?php if(isset($_GET["error"])):?>
                    <p class="error"><?php echo $_GET["error"]; ?></p>
                <?php endif; ?>
            </section>
        </div>
        <?php include __DIR__ . "/../templates/footer.php"; ?>
    </body>
</html>
<?php endif; ?>
<?php
if($_SERVER["REQUEST_METHOD"] === "POST") {
    function error($message) {
        $encodedMessage = urlencode($message);
        header("Location: /hotels/book.php?hotelID=" . $_POST["hotelID"] . "&error=$encodedMessage");
        return;
    }

    // Peform checks 
    if(!isset($_POST["customerID"])) {
        error("ERROR: Customer account not specified.");
        return;
    }
    if(!customerAccountExists($_POST["customerID"])) {
        error("ERROR: Customer account details could not be retrieved.");
        return;
    }

    if(!isset($_POST["hotelID"])) {
        error("ERROR: Hotel not specified.");
        return;
    }
    if(!hotelExists($_POST["hotelID"])) {
        error("ERROR: Hotel does not exist.");
        return;
    }
    
    if(!isset($_POST["datefrom"])) {
        error("ERROR: Booking start date has not been specified.");
        return;
    }
    if(!isset($_POST["dateto"])) {
        error("ERROR: Booking end date has not been specified.");
        return;
    }
    
    if(!isset($_POST["guests"])) {
        error("ERROR: Number of guests has not been specified.");
        return;
    }
    if($_POST["guests"] > 4 and $_POST["guests"] < 1) {
        error("ERROR: Number of guests has to be between 1 and 4");
        return;
    }

    // Check that datefrom isnt earlier than current date
    $dateFrom = date_create_from_format("Y-m-d", $_POST["datefrom"]);
    $dateTo = date_create_from_format("Y-m-d", $_POST["dateto"]);

    if($dateFrom < date_create()) {
        error("ERROR: Booking start date cannot be earlier than today.");
        return;
    }
    if($dateTo < date_create()) {
        error("ERROR: Booking end date cannot be earlier than today.");
        return;
    }
    if($dateTo <= $dateFrom) {
        error("ERROR: Booking end date has to be later than booking start date.");
        return;
    }

    if(getAvailableRooms($_POST["hotelID"], $_POST["datefrom"], $_POST["dateto"]) < 1) {
        error("Sorry, there are no rooms available for this booking slot");
        return;
    }

    createBooking(
        $_POST["customerID"],
        $_POST["hotelID"],
        $_POST["datefrom"],
        $_POST["dateto"],
        $_POST["guests"],
    );
    header("Location: /account/bookings/");
    return;
}
?>
