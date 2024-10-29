import './bootstrap.js';
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
    form.addEventListener('submit', function(event) {
        disableButton(button); // Désactive le bouton au moment de la soumission
        // Aucune redirection nécessaire ici, le formulaire sera soumis normalement
    });
};

