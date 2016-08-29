/*
 * This file is part of the Admin Bundle.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */

'use strict';

import $ from 'jquery';
import 'magnific-popup';

class ImagePopup {
  constructor(el) {
    $(el).magnificPopup({
      type: 'image'
    });
  }
}

export default ImagePopup;
