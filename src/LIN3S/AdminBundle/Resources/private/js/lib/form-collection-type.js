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

var $form = void 0,
    $collectionHolder = void 0;

function addFormType($collectionHolder) {
  var prototype = $collectionHolder.attr('data-prototype'),
      index = $collectionHolder.find(':input').length,
      newForm = prototype.replace(/__name__/g, index);

  (0, _jquery2.default)(newForm).appendTo($collectionHolder);
  $collectionHolder.data('index', index + 1);
}

function onReady() {
  $form = (0, _jquery2.default)('form');

  (0, _jquery2.default)('.form__collection-item-toggle').click(function () {
    (0, _jquery2.default)(this).parents('.form__collection-item').toggleClass('form__collection-item--hidden');
  });

  $form.on('click', '.js-collection-add', function (e) {
    e.preventDefault();

    $collectionHolder = (0, _jquery2.default)(this).closest('.form__collection').find('.form__collection-items').first();
    addFormType($collectionHolder);
  });

  $form.on('click', '.js-collection-remove', function (e) {
    e.preventDefault();

    (0, _jquery2.default)(this).closest('.form__collection-item').remove();
  });
}

var init = function init() {
  _lin3sEventBus.EventPublisher.subscribe(new _lin3sEventBus.DOMReadyEventSubscriber(onReady));
};

exports.default = init();