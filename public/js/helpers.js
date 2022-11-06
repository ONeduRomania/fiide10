/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*********************************!*\
  !*** ./resources/js/helpers.js ***!
  \*********************************/
// JQuery Code for Navigation | Smooth Scroll
function verifyNavbar() {
  var size = 30.0;
  if ($(this).scrollTop() > size) {
    $('.navbar').removeClass("bg-transparent").addClass("bg-royal");
  } else {
    $('.navbar').removeClass("bg-royal").addClass("bg-transparent");
  }
}
$(document).ready(function () {
  verifyNavbar();
});
$(document).scroll(function () {
  verifyNavbar();
});
$(document).on('click', 'a[href^="#"]', function (event) {
  event.preventDefault();
  $('html, body').animate({
    scrollTop: $($.attr(this, 'href')).offset().top
  }, 500);
});
/******/ })()
;