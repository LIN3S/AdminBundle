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

import {EventPublisher, DOMReadyEventSubscriber} from 'lin3s-event-bus';

import $ from 'jquery';

function onReady() {
  $('.menu-toggle').click(function () {
    var $menu = $(this).parents('.menu');

    $(this).toggleClass('menu-toggle--visible');
    if ($menu.hasClass('menu--open')) {
      $menu.attr('style', '');
    } else {
      $menu.height($menu.get(0).scrollHeight);
    }
    $menu.toggleClass('menu--open');
  });
}

const init = () => {
  EventPublisher.subscribe(
    new DOMReadyEventSubscriber(
      onReady
    )
  );
};

export default init();
