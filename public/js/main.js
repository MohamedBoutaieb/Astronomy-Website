var lastScrollTop = 0;
let nav = document.querySelector("header");
window.addEventListener("scroll", function () {
  let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
  if (scrollTop > lastScrollTop) {
    nav.style.top = "-300px";
  }
  else { nav.style.top = "0px"; }
  lastScrollTop = scrollTop;
})

