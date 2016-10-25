<?php

/*
 * This file is part of the Admin Bundle.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Locale controller.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class LocaleController extends Controller
{
    /**
     * Change locale action.
     *
     * @param Request $request The request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function switchLocaleAction(Request $request)
    {
        $locale = $locale = $request->getLocale();
        $request->getSession()->set('_locale', $locale);

        $refererUrl = $request->headers->get('referer');
        if (empty($refererUrl)) {
            return $this->redirectToRoute('lin3s_admin_dashboard');
        }

        return $this->redirect($refererUrl);
    }
}
