<?php

/*
 * This file is part of the Admin Bundle.
 *
 * Copyright (c) 2015-present LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\AdminBundle\Extension\ListField;

use LIN3S\AdminBundle\Configuration\Model\Entity;
use LIN3S\AdminBundle\Configuration\Type\ListFieldType;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Date list field type.
 *
 * @author Jagoba Perez <jagoba@lin3s.com>
 */
final class DateListFieldType implements ListFieldType
{
    /**
     * The translator.
     *
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * Constructor.
     *
     * @param TranslatorInterface $translator The Translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */
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

        if (is_array($entity)) {
            $value = new \DateTimeImmutable($entity[$options['field']]);
        } else {
            $properties = explode('.', $options['field']);
            $value = $entity;
            foreach ($properties as $property) {
                $value = $value->$property();
            }
        }

        if (null === $value) {
            return $this->translator->trans('lin3s_admin.list.field_type.date.not_available');
        }
        if (!$value instanceof \DateTimeInterface) {
            throw new \Exception(sprintf('%s must implement the \DateTimeInterface', $value));
        }

        $format = isset($options['format']) ? $options['format'] : 'd M Y';

        return $value->format($format);
    }
}
