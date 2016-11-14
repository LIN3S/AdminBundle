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

/**
 * Twig json decode filter.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class TwigJsonDecodeFilter extends \Twig_Extension
{
    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return [
            'json_decode' => new \Twig_Filter_Method($this, 'jsonDecode'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'lin3s_admin_twig_json_decode';
    }

    /**
     * Callback of json decode Twig filter that returns resultant array.
     *
     * @param string $string The json
     *
     * @return array
     */
    public function jsonDecode($string)
    {
        return json_decode($string, true);
    }
}
