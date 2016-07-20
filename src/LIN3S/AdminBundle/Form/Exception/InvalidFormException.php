<?php

/*
 * This file is part of the Admin Bundle.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\AdminBundle\Form\Exception;

/**
 * Invalid form exception.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirka@gmail.com>
 */
class InvalidFormException extends \Exception
{
    /**
     * Array which contains the form errors.
     *
     * @var array
     */
    protected $formErrors;

    /**
     * Constructor.
     *
     * @param array $formErrors Array which contains the form errors
     */
    public function __construct(array $formErrors = [])
    {
        $this->formErrors = $formErrors;
        parent::__construct('Invalid form');
    }

    /**
     * Gets form errors.
     *
     * @return array
     */
    public function getFormErrors()
    {
        return $this->formErrors;
    }
}
