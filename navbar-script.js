$(document).ready(function () {
    // Ajouter la classe active au chargement de la page pour le lien correspondant au chemin
    var currentPath = window.location.pathname;
    $(".navbar-nav a[href='" + currentPath + "']").addClass("active");

    // Ajouter la classe active au lien "Accueil" si le chemin correspond à la page d'accueil
    if (currentPath === "/" || currentPath === "/index.html") {
        $(".navbar-nav a[href='/index.html']").addClass("active");
    }
});