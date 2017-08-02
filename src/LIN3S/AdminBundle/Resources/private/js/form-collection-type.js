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

import {onDomReady} from 'lin3s-event-bus';
import $ from 'jquery';

const
  addFormType = ($aCollectionHolder) => {
    let
      prototype = $aCollectionHolder.attr('data-prototype'),
      prototypeName = $aCollectionHolder.attr('data-prototype-name'),
      regExp = new RegExp(prototypeName === undefined ? '__name__' : prototypeName, 'g'),
      index = $aCollectionHolder.find('input, textarea, select, button').length,
      newForm = prototype.replace(regExp, index);

    $(newForm).appendTo($aCollectionHolder);
    $aCollectionHolder.data('index', index + 1);
  },
  onReady = () => {
    const
      $formCollectionAddButtons = $('.js-collection-add'),
      $formCollectionRemoveButtons = $('.js-collection-remove'),
      $formToggles = $('.form__collection-item-toggle');

    Array.from($formCollectionAddButtons).forEach(formCollectionAddButton => {
      const $formCollectionAddButton = $(formCollectionAddButton);

      $formCollectionAddButton.on('click', () => {
        const $collectionHolder = $formCollectionAddButton
          .closest('.form__collection').find('.form__collection-items').first();
        addFormType($collectionHolder);

        return false;
      });
    });

    Array.from($formCollectionRemoveButtons).forEach(formCollectionRemoveButton => {
      const $formCollectionRemoveButton = $(formCollectionRemoveButton);
      $formCollectionRemoveButton.closest('.form__collection-item').remove();

      return false;
    });

    Array.from($formToggles).forEach(formToggle => {
      const $formToggle = $(formToggle);

      $formToggle.on('click', function () {
        $formToggle.closest('.form__collection-item').toggleClass('form__collection-item--hidden')
      });
    });
  };

onDomReady(onReady);
