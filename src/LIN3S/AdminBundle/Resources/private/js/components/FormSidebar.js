/*
 * This file is part of the Admin Bundle.
 *
 * Copyright (c) 2015-present LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrés Montejo <andres@lin3s.com>
 */

import {onDomReady} from 'lin3s-event-bus';

class FormSidebar {
  constructor(rootNode) {
    this.rootNode = rootNode;
    this.fixedElement = this.rootNode.querySelector('.form-sidebar__fixed');
    this.fixedElementWidth = this.fixedElement.offsetWidth;

    this.onScroll = this.onScroll.bind(this);

    window.addEventListener('scroll', () => requestAnimationFrame(this.onScroll));
  }

  offsetTop() {
    const rect = this.rootNode.getBoundingClientRect();

    return rect.top + document.body.scrollTop;
  }

  onScroll() {
    if (document.body.scrollTop > this.offsetTop() - 20) {
      this.rootNode.style.position = 'relative';

      this.fixedElement.style.position = 'fixed';
      this.fixedElement.style.top = '20px';
      this.fixedElement.style.width = `${this.fixedElementWidth}px`;
    } else {
      this.rootNode.removeAttribute('style');
      this.fixedElement.removeAttribute('style');
    }
  }
}

const onReady = () => {
  const rootNode = document.querySelector('.form-sidebar');

  if (null === rootNode) {
    return;
  }

  new FormSidebar(rootNode);

};

onDomReady(onReady);
