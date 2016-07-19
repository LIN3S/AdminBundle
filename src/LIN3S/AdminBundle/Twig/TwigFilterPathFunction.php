<?php

/*
 * This file is part of the Admin Bundle.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\AdminBundle\Twig;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;

class TwigFilterPathFunction extends \Twig_Extension
{
    protected $router;
    /**
     * @var RequestStack
     */
    private $requestStack;

    public function __construct(RouterInterface $router, RequestStack $requestStack)
    {
        $this->router = $router;
        $this->requestStack = $requestStack;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('filterPath', [$this, 'filterPath']),
        ];
    }

    public function filterPath($field, $currentOrderBy, $currentOrder = 'ASC')
    {
        $request = $this->requestStack->getMasterRequest();

        if ($currentOrderBy === $field) {
            $currentOrder = $currentOrder === 'DESC' ? 'ASC' : 'DESC';
        } else {
            $currentOrder = 'ASC';
        }

        return $this->router->generate(
            $request->attributes->get('_route'),
            array_merge($request->query->all(), [
                'entity'  => $request->get('entity'),
                'orderBy' => $field,
                'order'   => $currentOrder,
                'page'    => 1,
            ])
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'lin3s_admin_twig_filter_path';
    }
}
