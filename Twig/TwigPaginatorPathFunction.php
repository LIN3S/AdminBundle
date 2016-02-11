<?php

/*
 * This file is part of the Denbolan project.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\AdminBundle\Twig;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;

class TwigPaginatorPathFunction extends \Twig_Extension
{
    protected $router;
    /**
     * @var RequestStack
     */
    private $requestStack;

    function __construct(RouterInterface $router, RequestStack $requestStack)
    {
        $this->router = $router;
        $this->requestStack = $requestStack;
    }

    /**
     * @inheritDoc
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('paginatorPath', [$this, 'paginatorPath'])
        ];
    }

    public function paginatorPath($page)
    {
        $request = $this->requestStack->getMasterRequest();

        return $this->router->generate(
            $request->attributes->get('_route'),
            array_merge($request->query->all(), [
                'entity' => $request->get('entity'),
                'page' => $page
            ])
        );
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return 'lin3s_admin_twig_paginator_path';
    }
}
