/**
 * @file
 * Back button functionality for The Blueprint installer.
 */

(function () {
  'use strict';

  document.addEventListener('DOMContentLoaded', function () {
    const backButtons = document.querySelectorAll('.blueprint-button--back');

    backButtons.forEach(function (button) {
      button.addEventListener('click', function (e) {
        e.preventDefault();
        history.back();
      });

      // Change button type to prevent form submission
      button.type = 'button';
    });
  });
})();
