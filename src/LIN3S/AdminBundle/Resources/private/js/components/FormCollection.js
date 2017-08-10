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

class FormCollection {
  constructor() {
    this.addButtons = document.querySelectorAll('.js-form-collection-add');
    this.removeButtons = document.querySelectorAll('.js-form-collection-remove');
    this.visibilityToggles = document.querySelectorAll('.js-form-collection-visibility-toggle');

    this.onClickAdded = this.onClickAdded.bind(this);
    this.onClickRemoved = this.onClickRemoved.bind(this);
    this.onClickVisibilityToggled = this.onClickVisibilityToggled.bind(this);

    this.initializeObservers();
    this.bindAddListeners();
    this.bindRemoveListeners();
    this.bindVisibilityToggleListeners();
  }

  initializeObservers() {
    NodeAddedObserver.subscribe('js-form-collection-add', nodeAddedEvent =>
      this.bindAddListeners(nodeAddedEvent.nodes)
    );
    NodeAddedObserver.subscribe('js-form-collection-remove', nodeAddedEvent =>
      this.bindRemoveListeners(nodeAddedEvent.nodes)
    );
    NodeAddedObserver.subscribe('js-form-collection-visibility-toggle', nodeAddedEvent =>
      this.bindVisibilityToggleListeners(nodeAddedEvent.nodes)
    );
  }

  bindAddListeners(addButtons) {
    if (addButtons === undefined) {
      addButtons = this.addButtons;
    }

    Array.from(addButtons).forEach(addButton => {
      addButton.addEventListener('click', this.onClickAdded);
    });
  }

  bindRemoveListeners(removeButtons) {
    if (removeButtons === undefined) {
      removeButtons = this.removeButtons;
    }

    Array.from(removeButtons).forEach(removeButton => {
      removeButton.addEventListener('click', this.onClickRemoved);
    });
  }

  bindVisibilityToggleListeners(visibilityToggles) {
    if (visibilityToggles === undefined) {
      visibilityToggles = this.visibilityToggles;
    }

    Array.from(visibilityToggles).forEach(toggle => {
      toggle.addEventListener('click', this.onClickVisibilityToggled);
    });
  }

  onClickAdded(event) {
    event.preventDefault();

    const collectionHolder = event.currentTarget
      .closest('.form-collection')
      .querySelector('.form-collection__items');

    this.addFormType(collectionHolder);
  }

  addFormType(collectionHolder) {
    const
      prototype = collectionHolder.getAttribute('data-prototype'),
      prototypeName = collectionHolder.getAttribute('data-prototype-name'),
      regExp = new RegExp(!prototypeName ? '__name__' : prototypeName.replace(/[\'\"]/g, () => ''), 'g'),
      index = collectionHolder.querySelectorAll('.form-collection__item').length,
      newForm = prototype.replace(regExp, index.toString());

    collectionHolder.insertAdjacentHTML('beforeend', newForm);
    collectionHolder.setAttribute('data-index', (index + 1).toString());
  }

  onClickRemoved(event) {
    event.preventDefault();

    const
      collectionHolder = event.currentTarget,
      collectionItem = collectionHolder.closest('.form-collection__item');

    collectionItem.parentNode.removeChild(collectionItem);
  }

  onClickVisibilityToggled(event) {
    const
      collectionHolder = event.currentTarget,
      collectionItem = collectionHolder.closest('.form-collection__item');

    collectionItem.classList.toggle('form-collection__item--hidden');
  }
}

document.addEventListener('DOMContentLoaded', () => {
  if (document.querySelectorAll('.form-collection').length) {
    new FormCollection();
  }
});
