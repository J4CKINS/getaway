let mobileNav = document.getElementById("mobile-nav");
let accountMenu = document.getElementById("account-menu")

let toggleMobileNav = () => {
    
    // Hide the account menu if it is already open
    if (accountMenu.style.display !== "none") {
        accountMenu.style.display = "none";
    }

    // If nav is hiding, show it
    if (mobileNav.style.display === "none") {
        mobileNav.style.display = "flex";
    }else {
        // Hide nav
        mobileNav.style.display = "none";
    }
}

let toggleAccountMenu = () => {
    // Hide the mobile nav if it is already open
    if (mobileNav.style.display !== "none") {
        mobileNav.style.display = "none";
    }

    // If menu is hiding, show it
    if (accountMenu.style.display === "none") {
        accountMenu.style.display = "flex";
    }else {
        // Hide nav
        accountMenu.style.display = "none";
    }
}
