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
use LIN3S\AdminBundle\Configuration\Registry\EntityConfigurationRegistryInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class EntityConfigurationAnnotationListener
{
    protected $annotationReader;

    protected $entityConfiguration;

    public function __construct(Reader $annotationReader, EntityConfigurationRegistryInterface $entityConfiguration)
    {
        $this->annotationReader = $annotationReader;
        $this->entityConfiguration = $entityConfiguration;
    }

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
