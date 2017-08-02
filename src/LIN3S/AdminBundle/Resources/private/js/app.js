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
import FastClick from 'fastclick';
import svg4everybody from 'svg4everybody';
import {initParsley} from 'lin3s-front-foundation';

import './polyfills';
import './filter';
import './form-collection-type';
import './menu';
import './panel';

const onReady = () => {
  initParsley();
  new FastClick(document.body);
  svg4everybody();
};

onDomReady(onReady);
