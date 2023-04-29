window.intestazioneCambiata = false;
$(document).ready(function () {
    $('.navbar-toggler').on('click', function () {
        $('body').toggleClass('navbar--opened');
        if (window.intestazioneCambiata == false) {
            document.getElementById("contenuto-intestazione").innerHTML = "Progetto <em>COVID-19</em><br/><span style='line-height: 60px;'>(Informatica - Interrogazioni SQL)</span>";
            window.intestazioneCambiata = true;
        } else {
            document.getElementById("contenuto-intestazione").innerHTML = "Progetto <em>COVID-19</em> (Informatica - Interrogazioni SQL)";
            window.intestazioneCambiata = false;
        }
    });
});