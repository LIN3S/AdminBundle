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

import {onDomReady} from 'lin3s-event-bus';

class Filter {
  constructor(rootNode) {
    this.options = rootNode.querySelector('.filter__options');
    this.filterBy = rootNode.querySelector('.filter__filter-by');

    this.onFilterByChanged = this.onFilterByChanged.bind(this);

    this.filterBy.addEventListener('change', this.onFilterByChanged);
  }

  onFilterByChanged(event) {
    const
      optionInputs = this.options.children,
      filter = this.options.querySelector(`[data-filter-field="${event.currentTarget.value}"]`),
      focusEvent = document.createEvent('HTMLEvents');

    Array.from(optionInputs).forEach((optionInput) => {
      optionInput.classList.add('filter__option--hidden');
      optionInput.setAttribute('name', '');
    });

    focusEvent.initEvent('focus', true, false);

    filter.classList.remove('filter__option--hidden');
    filter.setAttribute('name', 'filter');
    filter.dispatchEvent(focusEvent);
  }
}

const onReady = () => {
  const filters = document.querySelectorAll('.filter');

  if (filters.length === 0) {
    return;
  }

  Array.from(filters).forEach(filter => new Filter(filter));
};

onDomReady(onReady);
