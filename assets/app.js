
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';


// app.js

var animateButton = function (e) {

    e.preventDefault;
    //reset animation
    e.target.classList.remove('animate');

    e.target.classList.add('animate');
    setTimeout(function () {
        e.target.classList.remove('animate');
    }, 700);
};

var bubblyButtons = document.getElementsByClassName("bubbly-button");

for (var i = 0; i < bubblyButtons.length; i++) {
    bubblyButtons[i].addEventListener('mouseover', animateButton, false);
}


// Fonction pour désactiver le bouton
function disableButton(button) {
    button.disabled = true;
    setTimeout(() => {
        button.disabled = false;
    }, 10000); // 5 secondes
}

// Appelle onPageLoad lorsque la page est chargée
window.onload = () => {
    const button = document.querySelector('.bubbly-button');
    const form = document.getElementById('gachaForm');

    button.disabled = true; // Désactive le bouton au chargement
    setTimeout(() => {
        button.disabled = false; // Réactive le bouton après 10 secondes
    }, 5000); // 10 secondes

    // Ajoute l'écouteur d'événements au formulaire
    form.addEventListener('submit', function (event) {
        disableButton(button); // Désactive le bouton au moment de la soumission
        // Aucune redirection nécessaire ici, le formulaire sera soumis normalement
    });
};



var x;
var $cards = $(".card");
var $style = $(".hover");

$cards
    .on("mousemove touchmove", function (e) {
        // normalise touch/mouse
        var pos = [e.offsetX, e.offsetY];
        e.preventDefault();
        if (e.type === "touchmove") {
            pos = [e.touches[0].clientX, e.touches[0].clientY];
        }
        var $card = $(this);
        // math for mouse position
        var l = pos[0];
        var t = pos[1];
        var h = $card.height();
        var w = $card.width();
        var px = Math.abs(Math.floor(100 / w * l) - 100);
        var py = Math.abs(Math.floor(100 / h * t) - 100);
        var pa = (50 - px) + (50 - py);
        // math for gradient / background positions
        var lp = (50 + (px - 50) / 1.5);
        var tp = (50 + (py - 50) / 1.5);
        var px_spark = (50 + (px - 50) / 7);
        var py_spark = (50 + (py - 50) / 7);
        var p_opc = 20 + (Math.abs(pa) * 1.5);
        var ty = ((tp - 50) / 2) * -1;
        var tx = ((lp - 50) / 1.5) * .5;
        // css to apply for active card
        var grad_pos = `background-position: ${lp}% ${tp}%;`
        var sprk_pos = `background-position: ${px_spark}% ${py_spark}%;`
        var opc = `opacity: ${p_opc / 100};`
        var tf = `transform: rotateX(${ty}deg) rotateY(${tx}deg)`
        // need to use a <style> tag for psuedo elements
        var style = `
      .card:hover:before { ${grad_pos} }  /* gradient */
      .card:hover:after { ${sprk_pos} ${opc} }   /* sparkles */ 
    `
        // set / apply css class and style
        $cards.removeClass("active");
        $card.removeClass("animated");
        $card.attr("style", tf);
        $style.html(style);
        if (e.type === "touchmove") {
            return false;
        }
        clearTimeout(x);
    }).on("mouseout touchend touchcancel", function () {
        // remove css, apply custom animation on end
        var $card = $(this);
        $style.html("");
        $card.removeAttr("style");
        x = setTimeout(function () {
            $card.addClass("animated");
        }, 2500);
    });