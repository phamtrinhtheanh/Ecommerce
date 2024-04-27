const menu = document.querySelector('#menu-btn')
const navbar = document.querySelector(".header .nav")
const header = document.querySelector(".header")

menu.onclick = () => {
    menu.classList.toggle("fa-times")
    navbar.classList.toggle("active")

}
