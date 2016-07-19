<?php

/*
 * This file is part of the Admin Bundle.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\AdminBundle\Form;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class Handler.
 */
class FormHandler
{
    /**
     * The factory used to create a new Form instance.
     *
     * @var \Symfony\Component\Form\FormFactoryInterface
     */
    protected $formFactory;

    /**
     * The name of the form.
     *
     * @var string
     */
    protected $formName;

    /**
     * Manager used to persist and flush the object.
     *
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    protected $manager;

    /**
     * Constructor.
     *
     * @param \Symfony\Component\Form\FormFactoryInterface $formFactory Creates a new Form instance
     * @param \Doctrine\Common\Persistence\ObjectManager   $manager     Persists and flush the object
     */
    public function __construct(FormFactoryInterface $formFactory, ObjectManager $manager)
    {
        $this->formFactory = $formFactory;
        $this->manager = $manager;
    }

    /**
     * {@inheritdoc}
     */
    public function processForm(Request $request, $object = null, array $formOptions = [])
    {
        $form = $this->handleForm($request, $object, $formOptions);

        return !$object ? $form->getData() : $object;
    }

    /**
     * {@inheritdoc}
     */
    public function handleForm($formClass, $object = null, Request $request, array $formOptions = [])
    {
        $form = $this->createForm($formClass, $object, $formOptions);
        if ($request->isMethod('POST') || $request->isMethod('PUT') || $request->isMethod('PATCH')) {
            $form->handleRequest($request);
            if (!$form->isValid()) {
                return $form;
            }

            if (!$object) {
                $object = $form->getData();
            }

            $this->handleFiles($request->files, $object);
            $this->handleObject($object);
        }

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function createForm($formClass, $object = null, array $formOptions = [])
    {
        return $this->formFactory->createNamedBuilder('', $formClass, $object, $formOptions)->getForm();
    }

    /**
     * Handles file upload.
     *
     * @param \Symfony\Component\HttpFoundation\FileBag $files  Files found in current request
     * @param object                                    $object Object been handled in the request
     */
    protected function handleFiles(FileBag $files, $object)
    {
    }

    /**
     * Edits (if needed), persists and flushes the object.
     *
     * @param object $object The object to be handled
     */
    protected function handleObject($object)
    {
        $this->manager->persist($object);
        $this->manager->flush();
    }

    /**
     * Returns all the errors from form into array.
     *
     * @param \Symfony\Component\Form\FormInterface $form The form
     *
     * @return array
     */
    protected function getFormErrors(FormInterface $form)
    {
        $errors = [];
        foreach ($form->getErrors() as $error) {
            $errors[] = $error->getMessage();
        }
        foreach ($form->all() as $child) {
            if (!$child->isValid()) {
                $errors[$child->getName()] = $this->getFormErrors($child);
            }
        }

        return $errors;
    }
}
