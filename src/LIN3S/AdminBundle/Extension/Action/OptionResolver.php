<?php

/*
 * This file is part of the Admin Bundle.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\AdminBundle\Extension\Action;

/**
 * Option resolver trait.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
trait OptionResolver
{
    private function checkRequired($options, $field)
    {
        if (!isset($options[$field])) {
            throw new \InvalidArgumentException(
                sprintf(
                    '%s option is required so, you must declare inside action in the admin.yml', $field
                )
            );
        }
    }
}