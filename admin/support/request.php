<?php
include __DIR__ . "/../../includes/mysql_tools.php";
include __DIR__ . "/../../includes/auth_admin.php";

if(!authAdmin()) {
    header("Location: /admin/login.php");
    return;
}

if (!isset($_GET["requestID"])) {
    header("Location: /admin/support/");
    return;
}

if (!supportRequestExists($_GET["requestID"])) {
    header("Location: /admin/support/");
    return;
}

$request = fetchSupportRequest($_GET["requestID"]);
?>
<!DOCTYPE html>
<html lang="en-GB">
    <head>
        <title>Getaway - Admin | Support Request</title>
        <?php include __DIR__ . "/../../templates/head.php"; ?>
        <link rel="stylesheet" type="text/css" href="/static/css/admin/support_request.css">
    </head>
    <body>
        <?php include __DIR__ . "/../../templates/nav.php"; ?>
        <div class="wrapper">
            <section id="request">
                <p><a href="/admin/support/">&leftarrow; Back</a></p>
                <div id="request-content">
                    <h2><?php echo $request["RequestSubject"]; ?></h2>
                    <p><b>From: <?php echo $request["Email"]; ?></b><p>
                    <p><b>
                        Status: 
                        <?php if($request["Resolved"] == 1): ?>
                            <span class="resolved">Resolved</span>
                        <?php else: ?>
                            <span class="unresolved">Unresolved</span>
                        <?php endif; ?>
                    </b></p>
                    <?php foreach(explode("\n", $request["RequestMessage"]) as $line):?>
                        <p><?php echo $line; ?></p>
                    <?php endforeach; ?>
                </div>
            </section>
            <section>
                <div id="controls">
                    <form action="mailto:<?php echo $request["Email"]; ?>">
                        <button type="submit">Reply</button>
                    </form>
                    <form action="resolve.php" method="POST">
                        <input type="hidden" name="requestID" value="<?php echo $request["ID"]; ?>"/>
                        <input type="hidden" name="resolved" value="<?php echo $request["Resolved"]?>"/>
                        <?php if($request["Resolved"]): ?>
                            <button type="Submit">Unresolve</button>
                        <?php else: ?>
                            <button type="Submit">Resolve</button>
                        <?php endif; ?>
                    </form>
                </div>
            </section>
        </div>
        <?php include __DIR__ . "/../../templates/footer.php"; ?>
    </body>
</html>