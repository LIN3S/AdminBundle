<?php

namespace LIN3S\AdminBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;

/**
 * Edit event.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class EditEvent extends Event
{
    /**
     * The request.
     *
     * @var Request
     */
    private $request;

    /**
     * The entity.
     *
     * @var mixed
     */
    private $entity;

    /**
     * Constructor.
     *
     * @param Request $request The request
     * @param mixed   $entity  The entity
     */
    public function __construct(Request $request, $entity)
    {
        $this->request = $request;
        $this->entity = $entity;
    }

    /**
     * Gets the request.
     *
     * @return Request
     */
    public function request()
    {
        return $this->request;
    }

    /**
     * Gets the entity.
     *
     * @return mixed
     */
    public function entity()
    {
        return $this->entity;
    }
}
