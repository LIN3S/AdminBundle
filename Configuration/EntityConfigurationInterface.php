<?php

/*
 * This file is part of the Denbolan project.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\AdminBundle\Configuration;

interface EntityConfigurationInterface
{
    /**
     * Returns the unique identifier of the entity configuration
     *
     * @return string
     */
    public function name();

    /**
     * Returns the full namespace including class name for the given entity
     *
     * For example: LIN3S\Bundle\ExampleBundle\Model\Example
     *
     * @return string
     */
    public function className();

    /**
     * An array of fields to be displayed in list view
     *
     * @return mixed
     */
    public function listFields();

    /**
     * Overridden form for the given entity that disables form generation
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    public function form();

    /**
     * Id field name used to retrieve entities by id.
     *
     * @return string
     */
    public function idField();

    /**
     * Amount of items to be shown per page in admin list.
     *
     * @return integer
     */
    public function listEntitiesPerPage();

    /**
     * Returns a key (field) value (ASC or DESC) array which will be used to order the entities in admin list by
     * default.
     *
     * For example ["title" => "ASC"].
     *
     * @return array
     */
    public function listOrderByDefault();

    /**
     * Enables a list of batch actions for the entity
     *
     * @return BatchActionInterface[]
     */
    public function listBatchActions();

    /**
     * Enables a list of individual actions for a single entity
     *
     * @return mixed
     */
    public function listEntityActions();
}
