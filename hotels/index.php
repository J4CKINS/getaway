<?php
include __DIR__ . "/../includes/mysql_tools.php";
$hotels = fetchAllHotels();
?>
<!DOCTYPE html>
<html lang="en-GB">
    <head>
        <title>Getaway - Hotels</title>
        <?php include __DIR__ . "/../templates/head.php"; ?>
        <link rel="stylesheet" type="text/css" href="/static/css/hotels.css">
    </head>
    <body>
        <?php include __DIR__ . "/../templates/nav.php"; ?>
        <div class="wrapper">
            <section>
                <h1>Hotels</h1>
            </section>
            <section>
            <?php if($hotels !== null): ?>
                <div id="hotel-list">
                <?php foreach($hotels as $hotel):?>
                    <div class="hotel">
                        <div class="top">
                            <div class="hotel-image" style="background-image: url('<?php echo fetchHotelPrimaryImage($hotel["ID"])["ImageURL"]?>')"></div>
                            <div class="hotel-info">
                                <h2><?php echo $hotel["HotelName"]; ?></h2>
                                <div class="info-item">
                                    <img src="/static/img/icons/email_black.svg"/>
                                    <p><?php echo $hotel["ContactEmail"]; ?></p>
                                </div>
                                <div class="info-item">
                                    <img src="/static/img/icons/phone_black.svg"/>
                                    <p><?php echo $hotel["ContactNumber"] ?></p>
                                </div>
                                <div class="info-item">
                                    <img src="/static/img/icons/location_black.svg"/>
                                    <p><?php echo $hotel["City"] . ", " . $hotel["Country"] ?></p>
                                </div>
                                <div class="info-item">
                                    <img src="/static/img/icons/price_black.svg"/>
                                    <p><?php echo $hotel["Price"] . " / Night" ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="bottom">
                            <div class="rating">
                            <?php
                            $avgRating = getHotelAvgRating($hotel["ID"]);
                            for($x = 0; $x < $avgRating; $x++):
                            ?>
                                <img src="/static/img/icons/star_full.svg"/>
                            <?php endfor; ?>
                            <?php for($x = 0; $x < (5 - $avgRating); $x++): ?>
                                <img src="/static/img/icons/star_empty.svg"/>
                            <?php endfor; ?>
                            </div>
                            <form action="hotel.php">
                                <input type="hidden" name="id" value="<?php echo $hotel["ID"]; ?>" />
                                <button>View Hotel</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
                </div>
                <?php else: ?>
                    <h2>No Hotels Available</h2>
                <?php endif; ?>
            </section>
        </div>
        <?php include __DIR__ . "/../templates/footer.php"; ?>
    </body>
</html>