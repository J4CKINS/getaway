let mobile_nav = document.getElementById("mobile-nav");

let toggleMobileNav = () => {
    // If nav is hiding, show it
    if (mobile_nav.style.display === "none") {
        mobile_nav.style.display = "flex";
    }else {
        // Hide nav
        mobile_nav.style.display = "none";
    }
}