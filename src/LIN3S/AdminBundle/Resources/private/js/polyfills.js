/*
 * This file is part of the Admin Bundle.
 *
 * Copyright (c) 2015-present LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Mikel Tuesta <mikeltuesta@gmail.com>
 * @author Beñat Espiña <benatespina@gmail.com>
 */

/**
 * Array.from polyfill for IE.
 */
if (typeof Array.from === 'undefined') {
  Array.from = require('array-from'); // eslint-disable-line no-undef
}

/**
 * Closest polyfill for IE.
 *
 * https://stackoverflow.com/a/35294561
 */
if (!Element.prototype.matches) {
  Element.prototype.matches = Element.prototype.msMatchesSelector;
}
if (!Element.prototype.closest) {
  Element.prototype.closest = function (selector) {
    let element = this; // eslint-disable-line consistent-this

    while (element) {
      if (element.matches(selector)) {
        return element;
      }
      element = element.parentElement;
    }

    return undefined;
  };
}
