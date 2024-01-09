// Navbar
const navbarElement = document.querySelector(".navbar");
fetch("head/header.html")
    .then((res) => {
        if (!res.ok) {
            throw new Error(`HTTP error! Status: ${res.status}`);
        }
        return res.text();
    })
    .then((data) => {
        navbarElement.innerHTML = data;
    })
    .catch((error) => {
        console.error('Error fetching header:', error);
    });

// HTML date
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

// Footer
const footerElement = document.querySelector(".footer");
fetch("head/footer.html")
    .then((res) => {
        if (!res.ok) {
            throw new Error(`HTTP error! Status: ${res.status}`);
        }
        return res.text();
    })
    .then((data) => {
        footerElement.innerHTML = data;
        footerAlign(); // Call footer alignment after loading footer content
    })
    .catch((error) => {
        console.error('Error fetching footer:', error);
    });

function footerAlign() {
    var footerHeight = $(".footer").outerHeight();
    $("body").css("margin-bottom", footerHeight); // Use "margin-bottom" instead of "padding-bottom"
}

$(window).resize(function () {
    footerAlign();
});
