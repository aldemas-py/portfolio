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
        // Populate the navbar with the fetched HTML content
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

        // Update the web date element with calculated years
        document.getElementById(elementId).innerHTML = `${years} ${years === 1 ? 'year' : 'years'}`;
    }

    // Initial call to update the web date
    updateWebDate();

    // Schedule updates every 24 hours
    setInterval(updateWebDate, 24 * 60 * 60 * 1000);
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
        // Populate the footer with the fetched HTML content
        footerElement.innerHTML = data;
        footerAlign(); // Call footer alignment after loading footer content
    })
    .catch((error) => {
        console.error('Error fetching footer:', error);
    });

// Function to align footer properly
function footerAlign() {
    // Calculate the height of the footer
    var footerHeight = $(".footer").outerHeight();
    // Set body's margin-bottom to the height of the footer
    $("body").css("margin-bottom", footerHeight);
}

// Attach the footerAlign function to window resize event
$(window).resize(function () {
    footerAlign();
});
