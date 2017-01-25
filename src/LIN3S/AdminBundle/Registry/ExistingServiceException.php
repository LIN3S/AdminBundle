<?php

/*
 * This file is part of the Admin Bundle.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\AdminBundle\Registry;

/**
 * This exception should be thrown by service registry
 * when given type already exists.
 *
 * @author Saša Stamenković <umpirsky@gmail.com>
 */
class ExistingServiceException extends \InvalidArgumentException
{
    public function __construct($context, $type)
    {
        parent::__construct(sprintf('%s of type "%s" already exists.', $context, $type));
    }
}
