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

class MenuToggle {
  constructor(rootNode) {
    this.menuToggle = rootNode;
    this.menu = this.menuToggle.closest('.menu');

    this.onClick = this.onClick.bind(this);

    this.menuToggle.addEventListener('click', this.onClick);
  }

  onClick(event) {
    event.preventDefault();

    this.menuToggle.classList.toggle('menu-toggle--visible');

    if (this.menu.classList.contains('menu--open')) {
      this.menu.setAttribute('style', '');
    } else {
      this.menu.style.height = `${this.menu.scrollHeight}px`;
    }

    this.menu.classList.toggle('menu--open');
  }
}

const onReady = () => {
  const menuToggles = document.querySelectorAll('.menu-toggle');

  if (menuToggles.length === 0) {
    return;
  }

  Array.from(menuToggles).forEach(menuToggle => new MenuToggle(menuToggle));
};

onDomReady(onReady);
