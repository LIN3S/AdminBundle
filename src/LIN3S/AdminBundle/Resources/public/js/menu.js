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
  $('.menu-toggle').click(function() {
    $(this).toggleClass('menu-toggle--visible');

    var $menu = $(this).parents('.menu');

    if($menu.hasClass('menu--open')) {
      $menu.attr('style', '');
    } else {
      $menu.height($menu.get(0).scrollHeight);
    }
    $menu.toggleClass('menu--open');
  });
}(jQuery));
