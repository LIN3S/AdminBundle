<?php

namespace LIN3S\AdminBundle\ListFields;

interface ListFieldType
{
    public function render($entity, $options);
}
