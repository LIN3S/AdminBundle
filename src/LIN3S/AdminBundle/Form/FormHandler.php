<?php

/*
 * This file is part of the Admin Bundle.
 *
 * Copyright (c) 2015-present LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\AdminBundle\Form;

use Doctrine\Common\Persistence\ObjectManager;
use LIN3S\AdminBundle\Form\Exception\InvalidFormException;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;

/**
 * Form type handler.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirka@gmail.com>
 */
class FormHandler
{
    /**
     * The factory used to create a new Form instance.
     *
     * @var FormFactoryInterface
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
     * @var ObjectManager
     */
    protected $manager;

    /**
     * Constructor.
     *
     * @param FormFactoryInterface $formFactory Creates a new Form instance
     * @param ObjectManager        $manager     Persists and flush the object
     */
    public function __construct(FormFactoryInterface $formFactory, ObjectManager $manager)
    {
        $this->formFactory = $formFactory;
        $this->manager = $manager;
    }

    /**
     * Handles the form and saves the object to the DB. All process can be changed extending
     * handleFiles and handleObject methods. See each methods doc for more info.
     *
     * @param string      $formClass   The FQCN of form type
     * @param object|null $object      The object to be edited with form content
     * @param Request     $request     Contains values sent by the user
     * @param array       $formOptions Array which contains the options that will be passed in the form create method
     *
     * @throws InvalidFormException    when the form is invalid
     * @throws InvalidOptionsException when the given options are invalid
     *
     * @return FormInterface
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
     * Creates a form with the given parameters.
     *
     * To simplify the request body parameters, the form name
     * is setting to '' when the form is going to be create.
     *
     * @param string      $formClass   The FQCN of form type
     * @param object|null $object      Model related to the form
     * @param array       $formOptions Array which contains the options that will be passed
     *
     * @throws InvalidOptionsException when the given options are invalid
     *
     * @return FormInterface
     */
    public function createForm($formClass, $object = null, array $formOptions = [])
    {
        return $this->formFactory->createNamedBuilder('', $formClass, $object, $formOptions)->getForm();
    }

    /**
     * Handles file upload.
     *
     * @param FileBag $files  Files found in current request
     * @param object  $object Object been handled in the request
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
     * @param FormInterface $form The form
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
