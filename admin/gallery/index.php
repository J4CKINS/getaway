<?php
include __DIR__ . "/../../includes/session.php";
include __DIR__ . "/../../includes/mysql_tools.php";

if (!(adminLoggedIn() and adminAccountExists($_SESSION["adminID"]))) {
    header("Location: /admin/login.php");
    return;
}
?>
<!DOCTYPE html>
<html lang="en-GB">
    <head>
        <title>Getaway - Admin | Gallery</title>
        <?php include __DIR__ . "/../../templates/head.php"?>
        <link rel="stylesheet" type="text/css" href="/static/css/admin/gallery.css">
    </head>
    <body>
        <?php include __DIR__ . "/../../templates/nav.php"?>
        <div class="wrapper">
            <section>
                <h1>Gallery</h1>
            </section>
            <section>
                <?php
                // Load all the hotels
                $hotels = fetchAllHotels();
                foreach($hotels as $hotel):
                ?>
                <div class="gallery">
                    <div>
                        <h2><?php echo $hotel["HotelName"]; ?></h2>
                        <p>Images: <?php echo fetchTotalHotelImages($hotel["ID"])?></p>
                    </div>
                    <form action="edit.php" method="get">
                        <input type="hidden" name="hotel" value="<?php echo $hotel['ID']?>"/>
                        <button type="submit">Edit</button>
                    </form>
                </div>
                <?php endforeach; ?>
            </section>
        </div>
        <?php include __DIR__ .  "/../../templates/footer.php" ?>
    </body>
</html>
