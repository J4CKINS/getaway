<?php
include __DIR__ . "/../../includes/mysql_tools.php";
include __DIR__ . "/../../includes/auth_admin.php";

if (!authAdmin()) {
    header("Location: /admin/login.php");
}
?>
<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (authAdmin()) {

        // If hotel_ID is set update hotel
        if (isset($_POST["hotel_ID"]) and hotelExists($_POST["hotel_ID"])) {
            updateHotel(
                $_POST["hotel_ID"],
                $_POST["hotel_name"],
                $_POST["hotel_description"],
                $_POST["contact_number"],
                $_POST["contact_email"],
                $_POST["street_address"],
                $_POST["city"],
                $_POST["postcode"],
                $_POST["country"],
                $_POST["price"],
                $_POST["available_rooms"]
            );
            header("Location: /admin/hotels/");
            return;
        }
        else {
            // Create new hotel record
            createHotel(
                $_POST["hotel_name"],
                $_POST["hotel_description"],
                $_POST["contact_number"],
                $_POST["contact_email"],
                $_POST["street_address"],
                $_POST["city"],
                $_POST["postcode"],
                $_POST["country"],
                $_POST["price"],
                $_POST["available_rooms"],
            );
            header("Location: /admin/hotels/");
            return;
        }
    }
    http_response_code(403);
    return;
}
?>
<!DOCTYPE html>
<html lang="en-GB">
    <head>
        <title>Getaway - New Hotel</title>
        <?php include __DIR__ . "/../../templates/head.php"?>
        <link rel="stylesheet" type="text/css" href="/static/css/admin/hotel_form.css">
    </head>
    <body>
        <?php include __DIR__ . "/../../templates/nav.php"?>
        <div class="wrapper">
            <section>
                <?php
                // If hotelID is specified, load hotel data and populate form
                if(isset($_GET["hotelID"])):
                
                    // Check if hotel exists
                    if (!hotelExists($_GET["hotelID"])) {
                        header("Location: /admin/hotels/hotel.php");
                        return;
                    }

                    // Fetch hotel data
                    $hotelData = fetchHotelData($_GET["hotelID"]);
                ?>
                <h1>Edit Hotel</h1>
                <form method="post">
                    <input value="<?php echo $hotelData["ID"]?>" type="hidden" name="hotel_ID"/>
                    <input value="<?php echo $hotelData["HotelName"]?>" type="text" name="hotel_name" placeholder="Hotel Name" maxlength="255" required/>
                    <textarea name="hotel_description" placeholder="Hotel Description" maxlength="1024" required><?php echo $hotelData["HotelDescription"]?></textarea>
                    <input value="<?php echo $hotelData["ContactNumber"]?>"  type="tel" name="contact_number" placeholder="Contact Number" maxlength="255" required/>
                    <input value="<?php echo $hotelData["ContactEmail"]?>"  type="email" name="contact_email" placeholder="Contact Email" maxlength="255" required/>
                    <input value="<?php echo $hotelData["StreetAddress"]?>"  type="text" name="street_address" placeholder="Street Address" maxlength="255" required/>
                    <input value="<?php echo $hotelData["City"]?>"  type="text" name="city" placeholder="City" maxlength="255" required/>
                    <input value="<?php echo $hotelData["Postcode"]?>"  type="text" name="postcode" placeholder="Postcode" maxlength="255" required/>
                    <input value="<?php echo $hotelData["Country"]?>"  type="text" name="country" placeholder="Country" maxlength="255" required/>
                    <input value="<?php echo $hotelData["Price"]?>"  type="number" name="price" placeholder="Price/Night" required/>
                    <input value="<?php echo $hotelData["AvailableRooms"]?>"  type="number" name="available_rooms" placeholder="Available Rooms" required/>
                    <button type="submit">Submit</button>
                </form>
                <form action="../gallery/edit.php">
                    <input type="hidden" name="hotel" value="<?php echo $hotelData["ID"]; ?>"/>
                    <button type="submit">View Images</button>
                </form>
                <?php else: ?>
                <h1>New Hotel</h1>
                <form method="post">
                    <input type="text" name="hotel_name" placeholder="Hotel Name" maxlength="255" required/>
                    <textarea name="hotel_description" placeholder="Hotel Description" maxlength="1024" required></textarea>
                    <input type="tel" name="contact_number" placeholder="Contact Number" maxlength="255" required/>
                    <input type="email" name="contact_email" placeholder="Contact Email" maxlength="255" required/>
                    <input type="text" name="street_address" placeholder="Street Address" maxlength="255" required/>
                    <input type="text" name="city" placeholder="City" maxlength="255" required/>
                    <input type="text" name="postcode" placeholder="Postcode" maxlength="255" required/>
                    <input type="text" name="country" placeholder="Country" maxlength="255" required/>
                    <input type="number" name="price" placeholder="Price/Night" required/>
                    <input type="number" name="available_rooms" placeholder="Available Rooms" required/>
                    <button type="submit">Submit</button>
                </form>
                <?php endif; ?>
            </section>
        </div>
        <?php include __DIR__ . "/../../templates/footer.php"?>
    </body>
</html>
