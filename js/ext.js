// Navbar
const nav = document.querySelector(".navbar");
fetch("head/header.html")
  .then((res) => res.text())
  .then((data) => {
    nav.innerHTML = data;
  });
// html date
function setDynamicWebDate(elementId, startDateString) {
  const startDate = new Date(startDateString);

  function updateWebDate() {
    const currentDate = new Date();
    const timeDifference = currentDate - startDate;

    const years = Math.floor(timeDifference / (1000 * 60 * 60 * 24 * 365));

    document.getElementById(elementId).innerHTML = `${years} ${years === 1 ? 'year' : 'years'}`;
  }

  updateWebDate();

  setInterval(updateWebDate, 24 * 60 * 60 * 1000); // Update every 24 hours
}

  
// footer

const foot = document.querySelector(".footer");
fetch("head/footer.html")
  .then((res) => res.text())
  .then((data) => {
    foot.innerHTML = data;
  });

function footerAlign() {
  var footerHeight = $(".footer").outerHeight();
  $("body").css("padding-bottom", footerHeight);
}

$(document).ready(function () {
  footerAlign();
  $(".footer").html(htmlString);
});

$(window).resize(function () {
  footerAlign();
});