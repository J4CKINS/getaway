<?php
require_once(__DIR__ . "/../includes/session.php");
require_once(__DIR__ . "/../includes/mysql_tools.php");
require_once(__DIR__ . "/../includes/auth_admin.php");
?>
<div>
    <?php
    if(authAdmin()) {
        include __DIR__ . "/admin_nav.php";
    }
    ?>
    <div class="nav-container">
        <nav>
            <p id="title" class="clickable">Getaway</p>
            <ul>
                <li class="clickable"><a href="/">Home</a></li>
                <li class="clickable"><a href="/hotels/">Hotels</a></li>
                <li class="clickable"><a href="/support.php">Contact Us</a></li>
            </ul>
            <span>
            <img id="nav-menu-icon" src="/static/img/icons/nav_menu_white.svg" onclick="toggleMobileNav();"/>
            <img id="account-icon" src="/static/img/icons/account_icon_white.svg" onclick="toggleAccountMenu();"/>
            </span>
        </nav>
        <div id="mobile-nav">
            <a href="/">Home</a>
            <a href="/hotels/">Hotels</a>
            <a href="/support.php">Contact Us</a>
            <img src="/static/img/icons/expand_less_white.svg" onclick="toggleMobileNav();"/>
        </div>
        <div id="account-menu-container">
        <div id="account-menu">
            <?php if(isset($_SESSION["customerID"]) and customerAccountExists($_SESSION["customerID"])): ?>
                <a href="/account/">Account Information</a>
                <a>View Bookings</a>
                <a href="/logout.php">Logout</a>
            <?php else: ?>
                <a href="/login.php">Login</a>
                <a href="/signup.php">Sign up</a>
            <?php endif; ?>
            <?php if(authAdmin()): ?>
                <a href="/admin/logout.php">Admin Logout</a>
            <?php else: ?>
                <a href="/admin/login.php">Admin Login</a>
            <?php endif; ?>
            <img src="/static/img/icons/expand_less_white.svg" onclick="toggleAccountMenu();"/>
        </div>
        </div>
        <script src="/static/js/nav.js"></script>
    </div>
</div>