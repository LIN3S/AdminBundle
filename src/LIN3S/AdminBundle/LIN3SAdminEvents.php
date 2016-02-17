<?php

namespace LIN3S\AdminBundle;

/**
 * Contains all events thrown in the LIN3SAdminBundle.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
final class LIN3SAdminEvents
{
    /**
     * The EDIT_INITIALIZE event occurs when the edit process is initialized.
     *
     * This event allows you to modify the default values of the request before handling the form.
     * The event listener method receives a LIN3S\AdminBundle\Event\EditEvent instance.
     */
    const EDIT_INITIALIZE = 'lin3s_admin.edit.initialize';

    /**
     * The EDIT_SUCCESS event occurs when the edit form is submitted successfully.
     *
     * This event allows you to set the response instead of using the default one.
     * The event listener method receives a LIN3S\AdminBundle\Event\FormEvent instance.
     */
    const EDIT_SUCCESS = 'lin3s_admin.edit.success';
}
