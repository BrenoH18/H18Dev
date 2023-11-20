//Início do script!
const span = document.querySelector(".span");
const navMenu = document.querySelector(".nav-menu");

span.addEventListener("click", () => {
    span.classList.toggle("active");
    navMenu.classList.toggle("active");
}) 
//Fim!