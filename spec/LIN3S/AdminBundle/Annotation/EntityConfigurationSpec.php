<?php

/*
 * This file is part of the Admin Bundle.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\LIN3S\AdminBundle\Annotation;

use Doctrine\Common\Annotations\Annotation;
use LIN3S\AdminBundle\Annotation\EntityConfiguration;
use PhpSpec\ObjectBehavior;

/**
 * Spec file of EntityConfiguration class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class EntityConfigurationSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(['key' => 'value']);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(EntityConfiguration::class);
    }

    function it_extends_doctrine_annotation()
    {
        $this->shouldHaveType(Annotation::class);
    }
}
