/*
 * This file is part of the LIN3S Admin project.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Beñat Espiña <bespina@lin3s.com>
 * @author Gorka Laucirica <gorka@lin3s.com>
 */

'use strict';

(function ($) {
  var $removeAction = $('.table__action--remove, .table__action--eliminar');

  if ($removeAction.length === 0) {
    return;
  }

  $removeAction.click(function () {
    if (confirm('Are you sure that you want to remove?')) {
      return true;
    }

    return false;
  });

}(jQuery));