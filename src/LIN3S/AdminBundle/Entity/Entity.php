<?php

namespace LIN3S\AdminBundle\Entity;

/**
 * Base entity interface for any
 * resource inside AdminBundle.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
interface Entity
{
    /**
     * Gets the id.
     *
     * @return string|int
     */
    public function id();
}
