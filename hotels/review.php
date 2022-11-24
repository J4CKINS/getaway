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
    ?>
    <!DOCTYPE html>
    <html lang="en-GB">
        <head>
            <title>Getaway - Review</title>
            <?php include __DIR__ . "/../templates/head.php"; ?>
            <link rel="stylesheet" type="text/css" href="/static/css/review.css">
        </head>
        <body>
            <?php include __DIR__ . "/../templates/nav.php"; ?>
            <div class="wrapper">
                <section>
                    <h2>Review: <?php echo fetchHotelData($_GET["hotelID"])["HotelName"]; ?></h2>
                </section>
                <section id="review">
                    <div id="rating">
                        <h3>Rating</h3>
                        <div>
                            <?php for($x = 1; $x<=5; $x++):?>
                                <img class="rating-star" src="/static/img/icons/star_full.svg" onclick="setRating(<?php echo $x?>)"/>
                            <?php endfor; ?>
                        </div>
                    </div>
                    <form method="POST">
                        <input type="hidden" name="customerID" value="<?php echo $_SESSION["customerID"]; ?>"/>
                        <input type="hidden" name="hotelID" value="<?php echo $_GET['hotelID']; ?>"/>
                        <input type="hidden" name="rating" id="rating-score" value="5"/>
                        <textarea name="review" placeholder="Write a review..." maxlength="1024" required></textarea>
                        <button type="submit">Submit</button>
                    </form>
                </section>
            </div>
            <?php include __DIR__ . "/../templates/footer.php"; ?>
            <script src="/static/js/review.js"></script>
        </body>
    </html>
<?php elseif($_SERVER["REQUEST_METHOD"] === "POST"):

    if(!customerAccountExists($_POST["customerID"])) {
        echo "ERROR";
        return;
    }

    if(!hotelExists($_POST["hotelID"])) {
        header("Location: /hotels/");
        return;
    }

    if($_POST["rating"] > 5 or $_POST["rating"] < 0) {
        header("Location: /hotels/review.php?hotelID=" . $_POST["hotelID"]);
        return;
    }

    createReview(
        $_POST["customerID"],
        $_POST["hotelID"],
        $_POST["rating"],
        $_POST["review"]
    );

    header("Location: /hotels/hotel.php?id=" . $_POST["hotelID"]);
    return;
?>
<?php endif; ?>