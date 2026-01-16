/**
 * @file
 * Custom progress bar theming for The Blueprint installer.
 */

(function (Drupal) {
  'use strict';

  /**
   * Theme override for the progress bar during recipe installation.
   */
  Drupal.theme.progressBar = function (id) {
    const escapedId = Drupal.checkPlain(id);
    
    return (
      '<div class="blueprint-progress-wrapper">' +
        '<p class="blueprint-question-label">Setting up your masterpiece</p>' +
        '<p class="blueprint-helper-text">This will only take a moment...</p>' +
        '<div id="' + escapedId + '" class="progress blueprint-progress-bar" aria-live="polite">' +
          '<div class="progress__label visually-hidden">&nbsp;</div>' +
          '<div class="progress__track">' +
            '<div class="progress__bar"></div>' +
          '</div>' +
          '<div class="progress__percentage visually-hidden"></div>' +
          '<div class="progress__description visually-hidden">&nbsp;</div>' +
        '</div>' +
      '</div>'
    );
  };

})(Drupal);
