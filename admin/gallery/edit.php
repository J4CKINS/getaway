<?php
include __DIR__ . "/../../includes/session.php";
include __DIR__ . "/../../includes/mysql_tools.php";
include __DIR__ . "/../../includes/auth_admin.php";

// Check if admin is logged in
if (!authAdmin()) {
    header("Location: /admin/login.php");
    return;
}

// Check if the hotel specified exists
if(!(isset($_GET["hotel"]) and hotelExists($_GET["hotel"]))) {
    header("Location: /admin/gallery");
}

$hotel = fetchHotelData($_GET["hotel"]);
?>
<!DOCTYPE html>
<html lang="en-GB">
    <head>
        <title>Getaway - Admin | Gallery Editor</title>
        <?php include __DIR__ . "/../../templates/head.php"; ?>
        <link rel="stylesheet" type="text/css" href="/static/css/admin/gallery_editor.css">
    </head>
    <body>
        <?php include __DIR__ . "/../../templates/nav.php" ?>
        <div class="wrapper">
            <section>
                <h1>Gallery</h1>
                <h2><?php echo $hotel["HotelName"]; ?></h2>
            </section>
            <section>
                <?php if(fetchTotalHotelImages($_GET["hotel"]) < 1):?>
                    <h3>No Images Available</h3>
                <?php else:?>
                    <div id="image-list">
                        <?php foreach(fetchHotelImages($_GET["hotel"]) as $image):?>
                        <div class="image-list-item">
                            <div class="image" style="background-image: url('<?php echo $image["ImageURL"]; ?>');"></div>
                            <form action="set_primary.php" method="POST">
                                <input type="hidden" name="imageID" value="<?php echo $image["ID"]; ?>"/>
                                <input type="hidden" name="hotelID" value="<?php echo $_GET["hotel"]?>"/>
                                    <?php if(isPrimaryImage($image["ID"], $_GET["hotel"])):?>
                                        <button type="button" class="disabled">Current Primary Image</button>
                                    <?php else: ?>
                                        <button type="submit" class="edit">Set as Primary Image</button>
                                    <?php endif; ?>
                            </form>
                            <form action="delete.php" method="POST">
                                <input type="hidden" name="imageID" value="<?php echo $image["ID"]?>"/>
                                <input type="hidden" name="hotelID" value="<?php echo $_GET["hotel"]?>"/>
                                <button type="submit" class="delete">Delete Image</button>
                            </form>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif;?>
            </section>
            <section>
                <h2>Upload Image</h2>
                <p>Supported Formats: JPEG, PNG</p>
                <form id="upload-form" action="upload.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="hotelID" value="<?php echo $hotel["ID"]; ?>"/>
                    <input type="file" name="image" required/>
                    <button type="submit">Upload</button>
                </form>
            </section>
        </div>
        <?php include __DIR__ . "/../../templates/footer.php" ?>
    </body>
</html>