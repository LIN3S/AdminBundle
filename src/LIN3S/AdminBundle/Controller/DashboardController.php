<?php

namespace LIN3S\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller
{
    public function indexAction() {
        return $this->render('@LIN3SAdmin/Dashboard/index.html.twig');
    }
}
