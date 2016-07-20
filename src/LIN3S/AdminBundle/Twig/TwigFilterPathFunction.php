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
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Twig filter path function.
 *
 * @author Gorka Laucirica <gorka.lauzirka@gmail.com>
 */
class TwigFilterPathFunction extends \Twig_Extension
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
            new \Twig_SimpleFunction('filterPath', [$this, 'filterPath']),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'lin3s_admin_twig_filter_path';
    }

    /**
     * Callback of paginator path Twig function that returns the generated url.
     *
     * @param string $field          The field
     * @param string $currentOrderBy The current order by
     * @param string $currentOrder   The current order, by default "ASC"
     *
     * @return string
     */
    public function filterPath($field, $currentOrderBy, $currentOrder = 'ASC')
    {
        $request = $this->requestStack->getMasterRequest();
        if ($currentOrderBy === $field) {
            $currentOrder = $currentOrder === 'DESC' ? 'ASC' : 'DESC';
        } else {
            $currentOrder = 'ASC';
        }

        return $this->urlGenerator->generate(
            $request->attributes->get('_route'),
            array_merge($request->query->all(), [
                'entity'  => $request->get('entity'),
                'orderBy' => $field,
                'order'   => $currentOrder,
                'page'    => 1,
            ])
        );
    }
}
