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

import {onDomReady} from 'lin3s-event-bus';
import $ from 'jquery';

const onReady = () => {
  const $panelHeaders = $('.panel__header');

  Array.from($panelHeaders).forEach(panelHeader => {
    const $panelHeader = $(panelHeader);

    $panelHeader.on('click', () => {
      $panelHeader.parent().toggleClass('panel--closed');
    });
  });
};

onDomReady(onReady);
