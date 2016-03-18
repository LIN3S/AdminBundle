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

  var $collectionHolder,
    $add = $('.js-collection-add');

  $collectionHolder = $('.form__collection-items');
  $collectionHolder.data('index', $collectionHolder.find(':input').length);

  $add.on('click', function (e) {
    e.preventDefault();

    addItemFormType();
  });

  $('form').on('click', '.js-collection-remove', function (e) {
    e.preventDefault();

    $(this).parents('.form__collection-item').remove();
  });

  function addItemFormType() {
    var
      prototype = $collectionHolder.attr('data-prototype'),
      index = $collectionHolder.data('index'),
      newForm = prototype.replace(/__name__/g, index);

    $(newForm).appendTo($collectionHolder);
    $collectionHolder.data('index', index + 1);
  }

  /**
   * Expands / Retracts form collection item content
   */
  $('.form__collection-item-toggle').click(function() {
    $(this).parents('.form__collection-item').toggleClass('form__collection-item--hidden');
  });
}(jQuery));
