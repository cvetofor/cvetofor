function enableScrolling() {
  document.body.style = "";
  document.querySelector(".header__row").style = ``;
  document.querySelector("html").classList.remove("disable-scrolling");
}
function disableScrolling() {
  const scrollWidth = window.innerWidth - document.documentElement.clientWidth;
  document.body.style = `padding-right: ${scrollWidth}px`;
  document.querySelector(
    ".header__row"
  ).style = `left: calc(50% - ${scrollWidth}px/2);`;
  document.querySelector("html").classList.add("disable-scrolling");
}
