<?php

/*
 * This file is part of the Admin Bundle.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\AdminBundle\Extension\ListField;

use LIN3S\AdminBundle\Configuration\Model\Entity;
use LIN3S\AdminBundle\Configuration\Type\ListFieldType;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * String list field type.
 *
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
final class StringListFieldType implements ListFieldType
{
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function header($name, Entity $configuration)
    {
        if (!isset($name)) {
            throw new \InvalidArgumentException('Field to be rendered must be passed as string');
        }

        return $this->translator->trans($name);
    }

    /**
     * {@inheritdoc}
     */
    public function render($entity, $options, Entity $configuration)
    {
        if (!isset($options['field'])) {
            throw new \InvalidArgumentException('Field to be rendered must be passed as string');
        }
        $properties = explode('.', $options['field']);

        $value = $entity;
        foreach ($properties as $property) {
            $value = $value->$property();
        }

        return $value;
    }
}
