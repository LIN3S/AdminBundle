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
import $ from 'jquery';

const onReady = () => {
  if ($('.filter').length === 0) {
    return;
  }

  const $options = $('.filter__options');

  $('.filter__filter-by').on('change', () => {
    $options.children().addClass('filter__option--hidden').attr('name', '');
    $options
      .find(`[data-filter-field="${$(this).val()}"]`)
      .removeClass('filter__option--hidden').attr('name', 'filter').trigger('focus');
  });
};

onDomReady(onReady);
