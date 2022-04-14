const nav = document.querySelector(".navbar");
fetch("head/header.html")
  .then((res) => res.text())
  .then((data) => {
    nav.innerHTML = data;
  });


function footerAlign() {
  $("#footer").css("display", "block");
  $("#footer").css("height", "auto");
  var footerHeight = $("#footer").outerHeight();
  $("body").css("padding-bottom", footerHeight);
  $("#footer").css("height", footerHeight);
}

$(document).ready(function () {
  footerAlign();
  $("footer").html(htmlString);


});

$(window).resize(function () {
  footerAlign();

});

const foot = document.querySelector(".footer");
fetch("head/footer.html")
  .then((res) => res.text())
  .then((data) => {
    foot.innerHTML = data;
  });