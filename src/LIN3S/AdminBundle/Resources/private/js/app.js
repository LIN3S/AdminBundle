/*
 * This file is part of the Admin Bundle.
 *
 * Copyright (c) 2015-present LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */

import {onDomReady} from 'lin3s-event-bus';
import {initParsley} from 'lin3s-front-foundation';
import FastClick from 'fastclick';

import './components/Filter';
import './components/FormCollection';
import './components/MenuToggle';
import './components/Panel';
import './polyfills';

const onReady = () => {
  initParsley();
  new FastClick(document.body);
};

onDomReady(onReady);
