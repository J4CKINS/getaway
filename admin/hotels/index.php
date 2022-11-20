<?php
include __DIR__ . "/../../includes/mysql_tools.php";
include __DIR__ . "/../../includes/auth_admin.php";

if(!authAdmin()) {
    header("Location: /admin/login.php");
    return;
}
?>
<!DOCTYPE html>
<html lang="en-GB">
    <head>
        <title>Getaway - Admin | Hotels</title>
        <?php include __DIR__ . "/../../templates/head.php"; ?>
        <link rel="stylesheet" type="text/css" href="/static/css/admin/hotels.css">
    </head>
    <body>
        <?php include __DIR__ . "/../../templates/nav.php";?>
        <div class="wrapper">
            <section>
                <h1>Hotels</h1>
            </section>
            <section>
                <form method="get" action="hotel.php">
                    <button type="submit">New Hotel</button>
                </form>
                <?php
                $hotels = fetchAllHotels();
                foreach ($hotels as $hotel):
                ?>
                <div class="hotel">
                    <h2><?php echo $hotel["HotelName"] ?></h2>
                    <div class="controls">
                        <form action="hotel.php" method="get">
                            <input name="hotelID" type="hidden" value="<?php echo $hotel['ID'] ?>"/>
                            <button type="submit" class="edit">Edit</button>
                        </form>
                        <form action="delete.php" method="post">
                            <input name="hotelID" type="hidden" value="<?php echo $hotel['ID'] ?>"/>
                            <button type="submit" class="delete">Delete</button>
                        </form>
                    </div>
                </div>
                <?php endforeach; ?>
            </section>
            <?php include __DIR__ . "/../../templates/footer.php";?>
        </div>
    </body>
</html>