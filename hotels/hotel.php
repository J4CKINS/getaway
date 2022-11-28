<?php
include __DIR__ . "/../includes/mysql_tools.php";

if(!isset($_GET["id"])) {
    header("Location: /hotels/");
    return;
}

if (!hotelExists($_GET["id"])) {
    header("Location: /hotels/");
    return;
}

$hotel = fetchHotelData($_GET["id"]);
?>
<!DOCTYPE html>
<html lang="en-GB">
    <head>
        <title>Getaway - Hotel | <?php echo $hotel["HotelName"]; ?></title>
        <?php include __DIR__ . "/../templates/head.php"; ?>
        <link rel="stylesheet" type="text/css" href="/static/css/hotel.css">
    </head>
    <body>
        <?php include __DIR__ . "/../templates/nav.php"; ?>
        <div class="wrapper">
            <section>
                <div id="hotel">
                    <div id="col-left">
                        <div id="showcase-image" style="background-image: url('<?php echo fetchHotelPrimaryImage($hotel["ID"])["ImageURL"];?>');"></div>
                        <div id="gallery">
                            <?php foreach(fetchHotelImages($hotel["ID"]) as $image): ?>
                                <?php $imageURL = $image["ImageURL"]; ?>
                                <div class="image" 
                                style="background-image: url('<?php echo $imageURL?>')" 
                                onclick="changeHotelShowcaseImage('<?php echo $imageURL?>')"></div>
                            <?php endforeach; ?>
                        </div>
                        <div id="rating">
                            <p>Rating:</p>
                            <div id="rating-score">
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
                        </div>
                        <form action="book.php">
                            <input type="hidden" name="hotelID" value="<?php echo $hotel["ID"]; ?>"/>
                            <button type="submit">Book Now</button>
                        </form>
                    </div>
                    <div id="col-right">
                        <h2><?php echo $hotel["HotelName"]; ?></h2>
                        <div id="info">
                            <div id="description">
                                <?php foreach(explode("\n", $hotel["HotelDescription"]) as $paragraph): ?>
                                <p><?php echo $paragraph ?></p>
                                <?php endforeach; ?>
                            </div>
                            <div id="info-items">
                                <div class="info-item">
                                    <img src="/static/img/icons/phone_black.svg"/>
                                    <p><?php echo $hotel["ContactNumber"]; ?></p>
                                </div>
                                <div class="info-item">
                                    <img src="/static/img/icons/email_black.svg"/>
                                    <p><?php echo $hotel["ContactEmail"]; ?></p>
                                </div>
                                <div class="info-item">
                                    <img src="/static/img/icons/location_black.svg"/>
                                    <p>
                                        <?php echo $hotel["StreetAddress"]; ?>, 
                                        <?php echo $hotel["City"]; ?>, 
                                        <?php echo $hotel["Postcode"]; ?>
                                    </p>
                                </div>
                                <div class="info-item">
                                    <img src="/static/img/icons/price_black.svg"/>
                                    <p>£<?php echo $hotel["Price"]; ?> / Night</p>
                                </div>
                            </div>
                        </div>
                        <form action="book.php">
                            <input type="hidden" name="hotelID" value="<?php echo $hotel["ID"]; ?>"/>
                            <button type="submit">Book Now</button>
                        </form>
                    </div>
                </div>
            </section>
            <section>
                <h2>Reviews</h2>
                <form action="review.php" id="review-link">
                        <input type="hidden" name="hotelID" value="<?php echo $hotel["ID"]; ?>"/>
                        <button type="submit">Write a Review</button>
                    </form>
                <div id="reviews">
                    <?php foreach(fetchHotelReviews($hotel["ID"]) as $review): ?>
                        <div class="review">
                            <div class="head">
                                <p class="customer-name"><?php echo $review["FirstName"] . " " . $review["LastName"]?></p>
                                <div class="rating">
                                    <?php for($x=0; $x < $review["Rating"]; $x++): ?>
                                        <img src="/static/img/icons/star_full.svg"/>
                                    <?php endfor; ?>
                                    <?php for($x=0; $x < 5 - $review["Rating"]; $x++): ?>
                                        <img src="/static/img/icons/star_empty.svg"/>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            <div class="review-content">
                                <?php foreach(explode("\n", $review["Review"]) as $paragraph): ?>
                                    <p><?php echo $paragraph?></p>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        </div>
        <?php include __DIR__ . "/../templates/footer.php"; ?>
        <script src="/static/js/hotel.js"></script>
    </body>
</html>