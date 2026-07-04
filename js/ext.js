function safeInjectHtml(selector, url) {
    const el = document.querySelector(selector);
    if (!el) return;

    fetch(url)
        .then((res) => {
            if (!res.ok) throw new Error(`HTTP error! Status: ${res.status}`);
            return res.text();
        })
        .then((html) => {
            el.innerHTML = html;
        })
        .catch((error) => {
            // Avoid hard failures on broken includes.
            console.error(`Error fetching ${url}:`, error);
        });
}

// Navbar + Footer includes
safeInjectHtml('.navbar', 'head/header.html');
safeInjectHtml('.footer', 'head/footer.html');

function setDynamicWebDate(elementId, startDateString) {
    const el = document.getElementById(elementId);
    if (!el) return;

    const startDate = new Date(startDateString);
    if (Number.isNaN(startDate.getTime())) return;

    const updateWebDate = () => {
        const currentDate = new Date();
        const timeDifference = currentDate - startDate;
        const years = Math.floor(timeDifference / (1000 * 60 * 60 * 24 * 365));
        el.textContent = `${years} ${years === 1 ? 'year' : 'years'}`;
    };

    updateWebDate();
    setInterval(updateWebDate, 24 * 60 * 60 * 1000);
}

function footerAlign() {
    const footer = document.querySelector('.footer');
    if (!footer) return;

    const footerHeight = footer.getBoundingClientRect().height;
    document.body.style.marginBottom = `${footerHeight}px`;
}

window.addEventListener('resize', () => {
    footerAlign();
});

// Re-align after footer injection
document.addEventListener('DOMContentLoaded', () => {
    // Give fetch a small moment to complete (simple/robust for static includes)
    setTimeout(footerAlign, 250);
});

