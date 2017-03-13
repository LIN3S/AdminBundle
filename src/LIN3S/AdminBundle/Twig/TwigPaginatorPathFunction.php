<?php

/*
 * This file is part of the Admin Bundle.
 *
 * Copyright (c) 2015-present LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\AdminBundle\Twig;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Twig filter path function.
 *
 * @author Gorka Laucirica <gorka.lauzirka@gmail.com>
 */
class TwigPaginatorPathFunction extends \Twig_Extension
{
    /**
     * The request stack.
     *
     * @var RequestStack
     */
    private $requestStack;

    /**
     * The URL generator.
     *
     * @var UrlGeneratorInterface
     */
    protected $urlGenerator;

    /**
     * Constructor.
     *
     * @param UrlGeneratorInterface $urlGenerator The URL generator
     * @param RequestStack          $requestStack The request stack
     */
    public function __construct(UrlGeneratorInterface $urlGenerator, RequestStack $requestStack)
    {
        $this->urlGenerator = $urlGenerator;
        $this->requestStack = $requestStack;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('paginatorPath', [$this, 'paginatorPath']),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'lin3s_admin_twig_paginator_path';
    }

    /**
     * Callback of paginator path Twig function that returns the generated url.
     *
     * @param int $page The number of page
     *
     * @return string
     */
    public function paginatorPath($page)
    {
        $request = $this->requestStack->getMasterRequest();

        return $this->urlGenerator->generate(
            $request->attributes->get('_route'),
            array_merge($request->query->all(), [
                'entity' => $request->get('entity'),
                'page'   => $page,
            ])
        );
    }
}
