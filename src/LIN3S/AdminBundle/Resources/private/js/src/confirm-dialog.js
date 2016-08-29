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

import $ from 'jquery';
import 'magnific-popup';

const dialog = (title, message) => {
  let result = '<div class="confirm-dialog mfp-with-anim">';

  if (typeof title !== 'undefined') {
    result += '<h2>' + title + '</h2>';
  }

  return result +
    '<div class="confirm-dialog__content"><p>' + message + '</p></div>' +
    '<div class="confirm-dialog__actions">' +
      '<button type="button" class="button button--secondary confirm-dialog__ok">✔</button>' +
      '<button type="button" class="button confirm-dialog__cancel">✘</button>' +
    '</div>' +
  '</div>';
};

class ConfirmDialog {
  constructor(el, content, callback) {
    $(el).magnificPopup({
      modal: true,
      items: {
        src: dialog(content.title, content.message),
        type: 'inline'
      },
      callbacks: {
        open: function () {
          const $content = $(this.content);

          $content.on('click', '.confirm-dialog__ok', () => {
            if (typeof callback == 'function') {
              callback();
            }
            $.magnificPopup.close();
            $(document).off('keydown', keydownHandler);
          });

          $content.on('click', '.confirm-dialog__cancel', () => {
            $.magnificPopup.close();
            $(document).off('keydown', keydownHandler);
          });

          const keydownHandler = (e) => {
            if (e.keyCode == 13) {
              $content.find('.confirm-dialog__ok').click();

              return false;
            } else if (e.keyCode == 27) {
              $content.find('.confirm-dialog__cancel').click();

              return false;
            }
          };
          $(document).on('keydown', keydownHandler);
        }
      }
    });
  }
}

export default ConfirmDialog;
