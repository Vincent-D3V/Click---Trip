// ROUTING
import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';
const routes = require('../../public/js/fos_js_routes.json');
Routing.setRoutingData(routes);

if(document.getElementById("padding-for-navbar")){
    document.getElementsByTagName("nav")[0].className = "nav container affix";
    document.getElementById("padding-for-navbar").style.paddingTop="65px";
} else {
    window.onscroll = () => {
        if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
            document.getElementsByTagName("nav")[0].className = "nav container affix";
        } else {
            document.getElementsByTagName("nav")[0].className = "nav container";
        }
    };
}

$('.navTrigger').click(function () {
    $(this).toggleClass('active');
    $("#mainListDiv").toggleClass("show_list");
    $("#mainListDiv").fadeIn();
});

$(function () {
    $('.footer-links-holder h3').click(function () {
        $(this).parent().toggleClass('active');
    });
});

document.getElementById('dropdown').addEventListener('click', (event) => {

    document.getElementById("myDropdown").classList.toggle("show");
});

document.getElementById('dropdown2').addEventListener('click', (event) => {

    document.getElementById("myDropdown2").classList.toggle("show");
});

document.getElementById('dropdown2').addEventListener('click', (event) => {
    fetch(Routing.generate('api_stages'))
        .then(results => results.json())
        .then(data => {
            let dest = data.map(stage => stage.destination);
            let unique = [...new Set(dest)];
            const dropdown = document.getElementById('myDropdown2');
            let html = '';
            unique.forEach(country =>
                html += `<a href='/mon-voyage/${country}'> ${country} </a>`);
            dropdown.innerHTML = html;
        })
})
