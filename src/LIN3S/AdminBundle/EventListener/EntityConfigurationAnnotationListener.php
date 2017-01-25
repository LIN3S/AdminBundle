<?php

/*
 * This file is part of the Admin Bundle.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\AdminBundle\EventListener;

use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\Util\ClassUtils;
use LIN3S\AdminBundle\Registry\ServiceRegistry;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

/**
 * Entity configuration annotation listener.
 *
 * @author Gorka Laucirica <gorka.lauzirka@gmail.com>
 */
class EntityConfigurationAnnotationListener
{
    /**
     * The annotation reader.
     *
     * @var Reader
     */
    protected $annotationReader;

    /**
     * The entity configuration.
     *
     * @var ServiceRegistry
     */
    protected $entityConfiguration;

    /**
     * Constructor.
     *
     * @param Reader          $annotationReader    The annotation reader
     * @param ServiceRegistry $entityConfiguration The entity configuration
     */
    public function __construct(Reader $annotationReader, ServiceRegistry $entityConfiguration)
    {
        $this->annotationReader = $annotationReader;
        $this->entityConfiguration = $entityConfiguration;
    }

    /**
     * Callback that subscribes the event on kernel controller.
     *
     * @param FilterControllerEvent $event The event
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        list($object, $method) = $controller;

        $className = ClassUtils::getClass($object);

        $reflectionClass = new \ReflectionClass($className);
        $reflectionMethod = $reflectionClass->getMethod($method);

        if ($this->annotationReader->getMethodAnnotation(
            $reflectionMethod, 'LIN3S\AdminBundle\Annotation\EntityConfiguration')
        ) {
            $entity = $this->entityConfiguration->get($event->getRequest()->attributes->get('entity'));
            $event->getRequest()->attributes->set('entityConfig', $entity);
        }
    }
}
