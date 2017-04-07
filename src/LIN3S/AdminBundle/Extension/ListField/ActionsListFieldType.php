<?php

/*
 * This file is part of the Admin Bundle.
 *
 * Copyright (c) 2015-present LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\AdminBundle\Extension\ListField;

use LIN3S\AdminBundle\Configuration\Model\Entity;
use LIN3S\AdminBundle\Configuration\Type\ListFieldType;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Actions list field type.
 *
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 * @author Beñat Espiña <gorka.lauzirika@gmail.com>
 */
final class ActionsListFieldType implements ListFieldType
{
    /**
     * The translator.
     *
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * The Twig.
     *
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * The URL generator.
     *
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * Constructor.
     *
     * @param TranslatorInterface   $translator   The Translator
     * @param \Twig_Environment     $twig         The Twig
     * @param UrlGeneratorInterface $urlGenerator The URL generator
     */
    public function __construct(
        TranslatorInterface $translator,
        \Twig_Environment $twig,
        UrlGeneratorInterface $urlGenerator
    ) {
        $this->urlGenerator = $urlGenerator;
        $this->twig = $twig;
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */
    public function header($name, Entity $configuration)
    {
        if (!isset($name)) {
            throw new \InvalidArgumentException('Field to be rendered must be passed as string');
        }

        return $this->translator->trans($name);
    }

    /**
     * {@inheritdoc}
     */
    public function render($entity, $options, Entity $configuration)
    {
        if (!isset($options['actions'])) {
            throw new \InvalidArgumentException('Actions key is required');
        }

        $html = '';
        foreach (json_decode($options['actions']) as $actionName) {
            $action = $configuration->getAction($actionName);

            $url = $this->urlGenerator->generate('lin3s_admin_custom', [
                'entity' => $configuration->name(),
                'id'     => $entity->id(),
                'action' => $action->name(),
            ]);

            $html .= $this->twig->render('@Lin3sAdmin/Admin/partials/table_action_link.html.twig', [
                'action' => $actionName,
                'name'   => $this->translator->trans(
                    array_key_exists('name', $action->options())
                        ? $action->options()['name']
                        : $action->name()
                ),
                'url'    => $url,
            ]);
        }

        return $html;
    }
}
