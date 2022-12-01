<?php
include __DIR__ . "/includes/session.php";
include __DIR__ . "/includes/mysql_tools.php";

$hotels = fetchIndexPageHotels();
?>
<!DOCTYPE html>
<html lang="en-GB">
    <head>
        <title>Getaway</title>
        <?php include  __DIR__ . "/templates/head.php"?>
        <link rel="stylesheet" type="text/css" href="/static/css/index.css">
    </head>
    <body>
        <?php include __DIR__ . "/templates/nav.php"?>
        <div class="wrapper">
            <header>
                <p>Book your perfect</p>
                <p id="header-title">Getaway</p>
            </header>
            <section>
                <form action="/hotels/">
                    <button type="submit">Find a Hotel</button>
                </form>
            </section>
            <section>
                <h2>Popular Hotels</h2>
                <div id="hotels">
                    <?php foreach($hotels as $hotel): ?>
                    <div class="hotel">
                        <img class="showcase-image" src="<?php echo fetchHotelPrimaryImage($hotel["ID"])["ImageURL"]; ?>"/>
                        <div class="info">
                            <h3><?php echo $hotel["HotelName"]?></h3>
                            <div class="info-items">
                                <div class="info-item">
                                    <img src="/static/img/icons/location_black.svg"/>
                                    <p><?php echo $hotel["City"]; ?>, <?php echo $hotel["Country"]?></p>
                                </div>
                                <div class="info-item">
                                    <img src="/static/img/icons/price_black.svg"/>
                                    <p>£<?php echo $hotel["Price"]; ?> / Night</p>
                                </div>
                            </div>
                            <div class="bottom">
                                <div class="rating">
                                    <?php for($x = 0; $x < round($hotel["AverageRating"]); $x++): ?>
                                        <img src="/static/img/icons/star_full.svg"/>
                                    <?php endfor; ?>
                                    <?php for($x = 0; $x < 5 - round($hotel["AverageRating"]); $x++): ?>
                                        <img src="/static/img/icons/star_empty.svg"/>
                                    <?php endfor; ?>
                                </div>
                                <form action="/hotels/hotel.php">
                                    <input type="hidden" name="id" value="<?php echo $hotel["ID"]; ?>"/>
                                    <button type="submit">View</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </section>
        </div>
        <?php include __DIR__ . "/templates/footer.php"?>
    </body>
</html>