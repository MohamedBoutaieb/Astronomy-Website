var lastScrollTop = 0;
var nav = document.querySelector("header");
window.addEventListener("scroll", function () {
  var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
  if (scrollTop > lastScrollTop) {
    nav.style.top = "-300px";
  }
  else { nav.style.top = "0px"; }
  lastScrollTop = scrollTop;
})

setTimeout(() => {
  const toggleButton = document.getElementsByClassName('toggle-button')[0]
  const navbarLinks = document.getElementsByClassName('navbar-links')[0]
  toggleButton.addEventListener('click', () => {
    navbarLinks.classList.toggle('active')
  })
}, 1000);
