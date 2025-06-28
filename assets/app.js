/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// Importer Bootstrap JS (avec Popper.js)
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

import TomSelect from 'tom-select';

document.addEventListener('DOMContentLoaded', () => {
    const selects = document.querySelectorAll('.tom-select');

    selects.forEach((select) => {
        new TomSelect(select, {
            plugins: ['remove_button'],
            create: false,
            allowEmptyOption: true,
        });
    });
});

// Importer le CSS de Bootstrap
// import 'bootstrap/dist/css/bootstrap.min.css';

document.addEventListener("DOMContentLoaded", () => {
    const progressContainers = document.querySelectorAll(".progress-circle-container");

    progressContainers.forEach((container) => {
        const score = parseFloat(container.dataset.score); // Récupère le score
        const percentage = score; // Convertir directement en pourcentage (0-100)

        const progressCircle = container.querySelector(".progress");
        const radius = progressCircle.r.baseVal.value; // Rayon du cercle
        const circumference = 2 * Math.PI * radius; // Calcul exact de la circonférence

        // Mettre à jour les styles SVG
        progressCircle.style.strokeDasharray = `${circumference}`;
        const offset = circumference - (circumference * percentage) / 100; // Calcul du remplissage
        progressCircle.style.strokeDashoffset = offset; // Met à jour le remplissage
    });
});



