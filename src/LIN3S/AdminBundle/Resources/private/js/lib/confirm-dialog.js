/*
 * This file is part of the Admin Bundle.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */

'use strict';

Object.defineProperty(exports, "__esModule", {
  value: true
});

var _jquery = require('jquery');

var _jquery2 = _interopRequireDefault(_jquery);

require('magnific-popup');

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var dialog = function dialog(title, message) {
  var result = '<div class="confirm-dialog mfp-with-anim">';

  if (typeof title !== 'undefined') {
    result += '<h2>' + title + '</h2>';
  }

  return result + '<div class="confirm-dialog__content"><p>' + message + '</p></div>' + '<div class="confirm-dialog__actions">' + '<button type="button" class="button button--secondary confirm-dialog__ok">✔</button>' + '<button type="button" class="button confirm-dialog__cancel">✘</button>' + '</div>' + '</div>';
};

var ConfirmDialog = function ConfirmDialog(el, content, callback) {
  _classCallCheck(this, ConfirmDialog);

  (0, _jquery2.default)(el).magnificPopup({
    modal: true,
    items: {
      src: dialog(content.title, content.message),
      type: 'inline'
    },
    callbacks: {
      open: function open() {
        var $content = (0, _jquery2.default)(this.content);

        $content.on('click', '.confirm-dialog__ok', function () {
          if (typeof callback == 'function') {
            callback();
          }
          _jquery2.default.magnificPopup.close();
          (0, _jquery2.default)(document).off('keydown', keydownHandler);
        });

        $content.on('click', '.confirm-dialog__cancel', function () {
          _jquery2.default.magnificPopup.close();
          (0, _jquery2.default)(document).off('keydown', keydownHandler);
        });

        var keydownHandler = function keydownHandler(e) {
          if (e.keyCode == 13) {
            $content.find('.confirm-dialog__ok').click();

            return false;
          } else if (e.keyCode == 27) {
            $content.find('.confirm-dialog__cancel').click();

            return false;
          }
        };
        (0, _jquery2.default)(document).on('keydown', keydownHandler);
      }
    }
  });
};

exports.default = ConfirmDialog;