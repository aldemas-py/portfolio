/* Portfolio helper scripts
 * Fixes missing functions referenced by HTML (e.g., setDynamicWebDate)
 */

(function () {
  'use strict';

  /**
   * Sets the text content of the element with given id to
   * "<n> years" since the given date.
   *
   * @param {string} elementId
   * @param {string} startDateISOorText - Example: "May 15, 2016"
   */
  function setDynamicWebDate(elementId, startDateISOorText) {
    try {
      var el = document.getElementById(elementId);
      if (!el) return;

      var start = new Date(startDateISOorText);
      if (Number.isNaN(start.getTime())) return;

      var now = new Date();

      // Calculate years difference with month/day consideration
      var years = now.getFullYear() - start.getFullYear();
      var beforeAnniversary =
        now.getMonth() < start.getMonth() ||
        (now.getMonth() === start.getMonth() && now.getDate() < start.getDate());

      if (beforeAnniversary) years -= 1;
      if (years < 0) years = 0;

      // HTML in index expects the value to be inserted directly.
      el.textContent = years + (years === 1 ? ' year' : ' years');
    } catch (e) {
      // Silent fail: portfolio pages should still render.
    }
  }

  // Expose to global scope (HTML calls setDynamicWebDate(...))
  window.setDynamicWebDate = setDynamicWebDate;
})();

