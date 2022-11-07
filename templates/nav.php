<div class="nav-container">
    <nav>
        <p id="title" class="clickable">Getaway</p>
        <ul>
            <li class="clickable"><a href="/">Home</a></li>
            <li class="clickable">Hotels</li>
            <li class="clickable">Contact Us</li>
        </ul>
        <span>
        <img id="nav-menu-icon" src="/static/img/icons/nav_menu_white.svg" onclick="toggleMobileNav();"/>
        <img id="account-icon" src="/static/img/icons/account_icon_white.svg" onclick="toggleAccountMenu();"/>
        </span>
    </nav>
    <div id="mobile-nav">
        <a href="/">Home</a>
        <a>Hotels</a>
        <a>Contact Us</a>
        <img src="/static/img/icons/expand_less_white.svg" onclick="toggleMobileNav();"/>
    </div>
    <div id="account-menu-container">
    <div id="account-menu">
        <a href="/account/">Account Information</a>
        <a>View Bookings</a>
        <a href="/logout.php">Logout</a>
        <img src="/static/img/icons/expand_less_white.svg" onclick="toggleAccountMenu();"/>
    </div>
    </div>
    <script src="/static/js/nav.js"></script>
</div>