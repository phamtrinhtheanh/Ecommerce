const menu = document.querySelector('#menu-btn')
const navbar = document.querySelector(".header .nav")
const header = document.querySelector(".header")
const subnav = document.querySelector(".sub-header")

menu.onclick = () => {
    menu.classList.toggle("fa-times")
    navbar.classList.toggle("active")

}

const sv = document.querySelector("#servicesscroll");
sv.onclick = () => {
    const servicesElement = document.querySelector('.services#services');
    const middleOfScreen = window.innerHeight / 2; // Calculate the middle of the screen

    // Calculate the position to scroll to, which is the middle of the element minus the middle of the screen
    const scrollToPosition = servicesElement.offsetTop - middleOfScreen + (servicesElement.offsetHeight / 2);

    window.scrollTo({
        top: scrollToPosition,
        behavior: 'smooth'
    });
};
