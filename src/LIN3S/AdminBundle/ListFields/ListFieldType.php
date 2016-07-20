<?php

/*
 * This file is part of the Admin Bundle.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\AdminBundle\ListFields;

/**
 * List field type.
 *
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
interface ListFieldType
{
    /**
     * Methods that renders the field type with the given params.
     *
     * @param mixed $entity  The related entity
     * @param array $options Array which contains options
     *
     * @return mixed
     */
    public function render($entity, $options);
}
