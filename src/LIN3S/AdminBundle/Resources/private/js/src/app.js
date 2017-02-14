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

import {listenDomReady, listenDomLoaded, onDomReady} from 'lin3s-event-bus';

import 'picturefill';
import svg4everybody from 'svg4everybody';
import fastClick from 'fastclick';

import './filter';
import './form-collection-type';
import './menu';
import './panel';

function initialize() {
  fastClick.attach(document.body); // eslint-disable-line new-cap
  svg4everybody();
}

listenDomReady();
listenDomLoaded();
onDomReady(initialize);
