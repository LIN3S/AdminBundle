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

import {NodeAddedObserver} from 'lin3s-event-bus';
import $ from 'jquery';

const addFormType = ($aCollectionHolder) => {
  let
    prototype = $aCollectionHolder.attr('data-prototype');
  const
    prototypeName = $aCollectionHolder.attr('data-prototype-name'),
    regExp = new RegExp(prototypeName === undefined ? '__name__' : prototypeName, 'g'),
    index = $aCollectionHolder.find('input, textarea, select, button').length,
    newForm = prototype.replace(regExp, index);

  $aCollectionHolder
    .append(newForm)
    .data('index', index + 1);
};

const bindCollectionAddListener = (buttonNodes) => {
  buttonNodes.forEach(buttonNode => {
    const $buttonNode = $(buttonNode);

    $buttonNode.on('click', () => {
      const $collectionHolder = $buttonNode
        .closest('.form__collection')
        .find('.form__collection-items')
        .first();
      addFormType($collectionHolder);

      return false;
    });
  });
};

const bindCollectionRemoveListener = (buttonNodes) => {
  buttonNodes.forEach(buttonNode => {
    const $buttonNode = $(buttonNode);

    $buttonNode.on('click', () => {
      $buttonNode.closest('.form__collection-item').remove();

      return false;
    });
  });
};

const onReady = () => {
  const
    $formCollectionAddButtons = $('.js-collection-add'),
    $formCollectionRemoveButtons = $('.js-collection-remove'),
    $formToggles = $('.form__collection-item-toggle');

  bindCollectionAddListener(Array.from($formCollectionAddButtons));
  bindCollectionRemoveListener(Array.from($formCollectionRemoveButtons));

  Array.from($formToggles).forEach(formToggle => {
    const $formToggle = $(formToggle);

    $formToggle.on('click', () => {
      $formToggle.closest('.form__collection-item').toggleClass('form__collection-item--hidden')
    });
  });

  NodeAddedObserver.subscribe('js-collection-remove', nodeAddedEvent =>
    bindCollectionRemoveListener(nodeAddedEvent.nodes)
  );

  NodeAddedObserver.subscribe('js-collection-add', nodeAddedEvent =>
    bindCollectionAddListener(nodeAddedEvent.nodes)
  );
};

$(() => {
 onReady();
});

