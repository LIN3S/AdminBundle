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

Object.defineProperty(exports, "__esModule", {
  value: true
});

var _lin3sEventBus = require('lin3s-event-bus');

var _jquery = require('jquery');

var _jquery2 = _interopRequireDefault(_jquery);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function onReady() {
  if ((0, _jquery2.default)('.filter').length === 0) {
    return;
  }

  (0, _jquery2.default)('.filter__filter-by').change(function () {
    var $options = (0, _jquery2.default)('.filter__options');

    $options.children().addClass('filter__option--hidden').attr('name', '');
    $options.find('[data-filter-field="' + (0, _jquery2.default)(this).val() + '"]').removeClass('filter__option--hidden').attr('name', 'filter').focus();
  });
}

var init = function init() {
  _lin3sEventBus.EventPublisher.subscribe(new _lin3sEventBus.DOMReadyEventSubscriber(onReady));
};

exports.default = init();