require('../scss/formRegistration.scss')

let button = document.getElementById('toggleForm');

button.addEventListener('click', () => {
    let form1 = document.getElementById('form1');
    if (form1.style.display === "block") {
        form1.style.display = "none";
        button.innerText = 'S\'inscrire en tant qu\'agence';
    } else {
        form1.style.display = "block";
        button.innerText = 'S\'inscrire en tant que client';
    }

    let form2 = document.getElementById('form2');
    if (form2.style.display === "none") {
        form2.style.display = "block";
        button.innerText = 'S\'inscrire en tant que client';
    } else {
        form2.style.display = "none";
        button.innerText = 'S\'inscrire en tant qu\'agence';
    }
});