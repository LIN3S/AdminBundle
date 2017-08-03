/*
 * This file is part of the Admin Bundle.
 *
 * Copyright (c) 2015-present LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */

import {NodeAddedObserver} from 'lin3s-event-bus';

class Collection {
  constructor() {
    this.addButtons = document.querySelectorAll('.js-collection-add');
    this.removeButtons = document.querySelectorAll('.js-collection-remove');
    this.toggles = document.querySelectorAll('.form__collection-item-toggle');

    this.onClickAdded = this.onClickAdded.bind(this);
    this.onClickRemoved = this.onClickRemoved.bind(this);

    this.initializeObservers();
    this.bindAddListeners();
    this.bindRemoveListeners();
    this.bindToggleListeners();
  }

  initializeObservers() {
    NodeAddedObserver.subscribe('js-collection-add', nodeAddedEvent =>
      this.bindAddListeners(nodeAddedEvent.nodes)
    );

    NodeAddedObserver.subscribe('js-collection-remove', nodeAddedEvent =>
      this.bindRemoveListeners(nodeAddedEvent.nodes)
    );
  }

  bindAddListeners() {
    Array.from(this.addButtons).forEach(addButton => {
      addButton.addEventListener('click', this.onClickAdded);
    });
  }

  bindRemoveListeners() {
    Array.from(this.removeButtons).forEach(removeButton => {
      removeButton.addEventListener('click', this.onClickRemoved);
    });
  }

  bindToggleListeners() {
    Array.from(this.toggles).forEach(toggle => {
      toggle.addEventListener('click', this.onClickToggled);
    });
  }

  onClickAdded(event) {
    event.preventDefault();

    const collectionHolder = event.currentTarget
        .closest('.form__collection')
        .querySelectorAll('.form__collection-items')[0];

    this.addFormType(collectionHolder);
  }

  addFormType(collectionHolder) {
    let prototype = collectionHolder.getAttribute('data-prototype');
    const
      prototypeName = collectionHolder.getAttribute('data-prototype-name'),
      regExp = new RegExp(prototypeName === undefined ? '__name__' : prototypeName, 'g'),
      index = collectionHolder.querySelectorAll('input, textarea, select, button') !== null,
      newForm = prototype.replace(regExp, index);

    collectionHolder.insertAdjacentHTML('beforeend', newForm);
    collectionHolder.setAttribute('data-index', index + 1);
  }

  onClickRemoved(event) {
    event.preventDefault();

    const
      collectionHolder = event.currentTarget,
      collectionItem = collectionHolder.closest('.form__collection-item');

    collectionItem.parentNode.removeChild(collectionItem);
  }

  onClickToggled(event) {
    const
      collectionHolder = event.currentTarget,
      collectionItem = collectionHolder.closest('.form__collection-item');

    collectionItem.classList.toggle('form__collection-item--hidden');
  }
}

document.addEventListener('DOMContentLoaded', () => {
  if (document.querySelectorAll('.form__collection').length) {
    new Collection();
  }
});
