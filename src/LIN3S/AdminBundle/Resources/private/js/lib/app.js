/*
 * This file is part of the Admin Bundle.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */

'use strict';

var _lin3sEventBus = require('lin3s-event-bus');

require('picturefill');

var _svg4everybody = require('svg4everybody');

var _svg4everybody2 = _interopRequireDefault(_svg4everybody);

var _fastclick = require('fastclick');

var _fastclick2 = _interopRequireDefault(_fastclick);

require('./filter');

require('./form-collection-type');

require('./menu');

require('./panel');

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function initialize() {
  (0, _fastclick2.default)(document.body);
  (0, _svg4everybody2.default)();
}

(function () {
  document.addEventListener('DOMContentLoaded', function () {
    initialize();
    _lin3sEventBus.EventPublisher.publish(new _lin3sEventBus.DOMReadyEvent());
  });
})();