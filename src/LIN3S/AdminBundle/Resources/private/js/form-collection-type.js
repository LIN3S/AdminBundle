/*
 * This file is part of the Admin Bundle.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */

'use strict';

(function ($) {

  var $form, $collectionHolder;

  function addFormType($collectionHolder) {
    var
      prototype = $collectionHolder.attr('data-prototype'),
      index = $collectionHolder.find(':input').length,
      newForm = prototype.replace(/__name__/g, index);

    $(newForm).appendTo($collectionHolder);
    $collectionHolder.data('index', index + 1);
  }

  $(document).ready(function () {
    $form = $('form');

    $('.form__collection-item-toggle').click(function () {
      $(this).parents('.form__collection-item').toggleClass('form__collection-item--hidden')
    });

    $form.on('click', '.js-collection-add', function (e) {
      e.preventDefault();

      $collectionHolder = $(this).closest('.form__collection').find('.form__collection-items').first();
      addFormType($collectionHolder);
    });

    $form.on('click', '.js-collection-remove', function (e) {
      e.preventDefault();

      $(this).closest('.form__collection-item').remove();
    });
  });

}(jQuery));
