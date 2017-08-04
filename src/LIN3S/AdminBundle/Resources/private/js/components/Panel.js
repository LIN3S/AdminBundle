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

class Panel {
  constructor(rootNode) {
    this.panel = rootNode;
    this.panelHeaders = this.panel.querySelectorAll('.panel__header');

    this.onClick = this.onClick.bind(this);

    Array.from(this.panelHeaders).forEach(panelHeader => panelHeader.addEventListener('click', this.onClick));
  }

  onClick(event) {
    event.preventDefault();

    this.panel.classList.toggle('panel--closed');
  }
}

const onReady = () => {
  const panels = document.querySelectorAll('.panel');

  if (panels.length === 0) {
    return;
  }

  Array.from(panels).forEach(panel => new Panel(panel));
};

onDomReady(onReady);
