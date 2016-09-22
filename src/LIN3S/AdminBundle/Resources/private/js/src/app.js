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

import {EventPublisher, DOMReadyEvent} from 'lin3s-event-bus';

import 'picturefill';
import svg4everybody from 'svg4everybody';
import FastClick from 'fastclick';

import './filter';
import './form-collection-type';
import './menu';
import './panel';
import './table-list-action';

function initialize() {
  FastClick(document.body);
  svg4everybody();
}

(() => {
  document.addEventListener('DOMContentLoaded', () => {
    initialize();
    EventPublisher.publish(new DOMReadyEvent());
  });
})();
