/*
 * This file is part of the LIN3S Admin project.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Beñat Espiña <bespina@lin3s.com>
 * @author Gorka Laucirica <gorka@lin3s.com>
 */

'use strict';

(function ($) {
  if($('.filter').length === 0) {
    return;
  }

  $('.filter__filter-by').change(function() {
    $('.filter__options').children().addClass('filter__option--hidden').attr('name', '');
    $('.filter__options').find('[data-filter-field="' + $(this).val() + '"]')
      .removeClass('filter__option--hidden').attr('name', 'filter').focus();
  });
//  $('.filter__options').children().eq(0).attr('name', 'filter');
//
//  $('.filter__options').children().each(function(index) {
//    if(index !== 0) {
//      $(this).addClass('filter__option--hidden');
//    }
//  })
}(jQuery));
