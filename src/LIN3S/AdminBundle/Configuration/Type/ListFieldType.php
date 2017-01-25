<?php

/*
 * This file is part of the Admin Bundle.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\AdminBundle\Configuration\Type;

use LIN3S\AdminBundle\Configuration\Model\Entity;

/**
 * List field type.
 *
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
interface ListFieldType
{
    public function header($options, Entity $configuration);

    /**
     * Methods that renders the field type with the given params.
     *
     * @param mixed $entity  The related entity
     * @param array $options Array which contains options
     * @param Entity $configuration
     *
     * @return mixed
     */
    public function render($entity, $options, Entity $configuration);
}
