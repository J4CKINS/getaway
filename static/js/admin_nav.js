let adminMenu       = document.getElementById("admin-menu-mobile");
let adminMenuToggle = document.getElementById("admin-menu-toggle");

let toggleAdminMenu = () => {
    if (adminMenu.style.display !== "none") {
        adminMenu.style.display = "none";
        adminMenuToggle.src = "/static/img/icons/expand_more_red.svg"
    }

    else if (adminMenu.style.display === "none") {
        adminMenu.style.display = "block";
        adminMenuToggle.src = "/static/img/icons/expand_less_red.svg"
    }
}