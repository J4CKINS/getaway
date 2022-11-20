 <?php
 include __DIR__ . "/../../includes/mysql_tools.php";
 include __DIR__ . "/../../includes/auth_admin.php";

 if (!authAdmin()) {
    header("Location: /admin/login.php");
    return;
 }


 if(isset($_GET["email"])) {
    $requests = fetchSupportRequestsByEmail(urldecode($_GET["email"]));
 }
 elseif(isset($_GET["resolved"])) {
    if($_GET["resolved"] == 1) {
        $requests = fetchAllSupportRequests(resolved: true);
    } else {
        $requests = fetchAllSupportRequests(resolved: false);
    }
 } else {
    $requests = fetchAllSupportRequests();
 }
 ?>

<!DOCTYPE html>
<html lang="en-GB">
    <head>
        <title>Getaway - Admin | Support Requests</title>
        <?php include __DIR__ . "/../../templates/head.php"; ?>
        <link rel="stylesheet" type="text/css" href="/static/css/admin/support.css">
    </head>
    <body>
        <?php include __DIR__ . "/../../templates/nav.php"; ?>
        <div class="wrapper">
            <section>
                <h1>Support Requests</h1>
            </section>
            <section>
                <h3>Filters</h3>
                <div id="filter-options">
                    <div class="filter-controls-group">
                        <form>
                            <input type="email" name="email" placeholder="Filter by email" required/>
                            <button type="submit">Search</button>
                        </form>
                    </div>
                    <div class="filter-controls-group">
                        <form>
                            <input type="hidden" name="resolved" value="1" />
                            <button type="submit">Resolved</button>
                        </form>
                        <form>
                            <input type="hidden" name="resolved" value="0" />
                            <button type="submit">Unresolved</button>
                        </form>
                        <form>
                            <button type="submit">Show All</button>
                        </form>
                    </div>
                    <div class="filter-controls-group">
                        <form>
                            <button type="submit">Clear Filters</button>
                        </form>
                    </div>
                </div>
                <?php if(count($requests) > 0):?>
                    <?php foreach($requests as $request):?>
                        <div class="support-request">
                            <div class="info">
                                <h2><?php echo $request["RequestSubject"]; ?></h2>
                                <p><?php echo $request["Email"]; ?></p>
                                <p>Request ID: <?php echo $request["ID"]; ?></p>
                                <?php if($request["Resolved"] == 1): ?>
                                    <p class="resolved">Resolved</p>
                                <?php else: ?>
                                    <p class="unresolved">Unresolved</p>
                                <?php endif; ?>
                            </div>
                            <form action="request.php">
                                <input type="hidden" name="requestID" value="<?php echo $request["ID"]; ?>"/>
                                <button type="submit">View Request</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <h2>No Requests Found</h2>
                <?php endif; ?>
            </section>
        </div>
        <?php include __DIR__ . "/../../templates/footer.php"; ?>
    </body>
</html>