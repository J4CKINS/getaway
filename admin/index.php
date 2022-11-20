<?php
include __DIR__ . "/../includes/auth_admin.php";

if (!authAdmin()) {
    header("Location: /admin/login.php");
    return;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Getaway - Admin</title>
        <?php include __DIR__ . "/../templates/head.php"; ?>
        <link rel="stylesheet" type="text/css" href="/static/css/admin/admin.css">
    </head>
    <body>
        <?php include __DIR__ . "/../templates/nav.php"; ?>
        <div class="wrapper">
            <section>
                <h1>Getaway</h1>
                <h2>Admin Panel</h2>
            </section>
            <section>
                <h3><a href="hotels/">Hotel Manager</a></h3>
                <h3><a href="gallery/">Gallery Manager</a></h3>
                <h3><a href="support/">View Support Requests</a></h3>
                <h3><a href="logout.php">Logout</a></h3>
            </section>
        </div>
        <?php include __DIR__ . "/../templates/footer.php"; ?>
    </body>
</html>