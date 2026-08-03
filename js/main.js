/* Njenga Sam Portfolio 2.0 - Main JS
 * Navbar mobile toggle + project iframe modal
 */
(function () {
  "use strict";

  // Mobile nav toggle
  var toggle = document.querySelector(".p-nav-toggle");
  var links = document.querySelector(".p-nav-links");

  if (toggle && links) {
    toggle.addEventListener("click", function () {
      links.classList.toggle("open");
      // animate hamburger to X
      var spans = toggle.querySelectorAll("span");
      spans.forEach(function (s) {
        s.classList.toggle("active");
      });
    });

    // Close menu when a link is clicked
    links.querySelectorAll("a").forEach(function (a) {
      a.addEventListener("click", function () {
        links.classList.remove("open");
        toggle.querySelectorAll("span").forEach(function (s) {
          s.classList.remove("active");
        });
      });
    });
  }

  // Project modal
  var modal = document.getElementById("projectModal");
  var frame = document.getElementById("projectModalFrame");

  function openModal(url) {
    if (!modal || !frame) return;
    frame.src = url;
    modal.classList.add("open");
    document.body.style.overflow = "hidden";
  }

  function closeModal() {
    if (!modal) return;
    modal.classList.remove("open");
    document.body.style.overflow = "";
    if (frame) {
      frame.src = "about:blank";
    }
  }

  // Wire up all project cards with data-project-url
  document
    .querySelectorAll(".p-project-card[data-project-url]")
    .forEach(function (card) {
      card.addEventListener("click", function (e) {
        // Ignore clicks on interactive links inside
        if (e.target.closest("a")) return;
        openModal(card.getAttribute("data-project-url"));
      });
    });

  // Close on backdrop click or close button
  document.querySelectorAll("[data-modal-close]").forEach(function (el) {
    el.addEventListener("click", closeModal);
  });

  // Close on escape
  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") closeModal();
  });

  // Expose for potential inline use
  window.openProjectModal = openModal;
  window.closeProjectModal = closeModal;
})();
