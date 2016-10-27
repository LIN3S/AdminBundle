<?php

/*
 * This file is part of the Admin Bundle.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\AdminBundle\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\QueryBuilder as DoctrineQueryBuilder;
use LIN3S\AdminBundle\Configuration\EntityConfiguration;
use LIN3S\AdminBundle\ListFields\ListField;
use Symfony\Component\HttpFoundation\Request;

/**
 * Default implementation of QueryBuilder.
 *
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 * @author Jagoba Perez <jagoba@lin3s.com>
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class DefaultQueryBuilder implements QueryBuilder
{
    /**
     * The entity manager.
     *
     * @var EntityManager
     */
    protected $manager;

    /**
     * Constructor.
     *
     * @param EntityManager $manager The entity manager
     */
    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * {@inheritdoc}
     */
    public function generate(Request $request, EntityConfiguration $config)
    {
        $queryBuilder = $this->manager->getRepository($config->className())->createQueryBuilder('a');
        $metadata = $this->manager->getClassMetadata($config->className());
        $associations = $this->resolveAssociations($config, $metadata);

        $queryBuilder->groupBy('a.' . $metadata->identifier[0]);

        foreach ($associations as $association) {
            $queryBuilder->join('a.' . $association, 'join_' . $association);
        }

        list($alias, $fields) = $this->getQueryAliasAndFields(
            $request->get('orderBy'),
            $request->get('order'),
            $metadata,
            $queryBuilder
        );

        if ($alias) {
            null === $fields
                ? $queryBuilder->addOrderBy($alias . $request->get('orderBy'), $request->get('order', 'ASC'))
                : $queryBuilder->addOrderBy($alias . '.' . $fields, $request->get('order', 'ASC'));
        }


        list($alias, $fields) = $this->getQueryAliasAndFields(
            $request->get('filterBy'),
            $request->get('filter'),
            $metadata,
            $queryBuilder
        );

        if ($alias) {
            null === $fields
                ? $queryBuilder->where($queryBuilder->expr()->like(
                $alias . '.' . $request->get('filterBy'),
                "'%" . $request->get('filter') . "%'"
            ))
                : $queryBuilder->where($queryBuilder->expr()->like(
                $alias . '.' . $fields,
                "'%" . $request->get('filter') . "%'"
            ));
        }

        return $this->removeDuplicateJoins($queryBuilder);
    }

    /**
     * Checks if the association is between two tables returning true,
     * otherwise, returns false if associations is based on inheritance.
     *
     * @param ClassMetadata $metadata    The class metadata
     * @param string        $association The association field name
     *
     * @return bool
     */
    private function isTableRelation($metadata, $association)
    {
        foreach ($metadata->fieldMappings as $fieldMapping) {
            if ($fieldMapping['fieldName'] === $association) {
                return false;
            }
        }

        return true;
    }

    /**
     * Resolves associations.
     *
     * @param EntityConfiguration $config   The entity configuration
     * @param ClassMetadata       $metadata The class metadata
     *
     * @return array
     */
    private function resolveAssociations(EntityConfiguration $config, ClassMetadata $metadata)
    {
        $associations = [];
        foreach ($metadata->getAssociationMappings() as $associationMapping) {
            $fieldName = $associationMapping['fieldName'];
            $fieldClass = array_filter($config->listFields(), function (ListField $field) use ($fieldName) {
                return $fieldName === explode('.', $field->options()['field'])[0];
            });

            if (count($fieldClass) > 0) {
                $associations[] = $fieldName;
            }
        }

        return $associations;
    }

    /**
     * Gets the result query alias and related fields.
     *
     * @param string               $criteriaBy   The criteria key
     * @param string               $criteria     The criteria value
     * @param ClassMetadata        $metadata     The Doctrine class metadata
     * @param DoctrineQueryBuilder $queryBuilder The query builder
     *
     * @return array
     */
    private function getQueryAliasAndFields(
        $criteriaBy,
        $criteria,
        ClassMetadata $metadata,
        DoctrineQueryBuilder $queryBuilder
    ) {
        if ($criteriaBy && $criteria) {
            $previousId = 97;

            if ($this->isTableRelation($metadata, $criteriaBy)) {
                $associations = explode('.', $criteriaBy);
                $fields = $associations;
                for ($i = 0; $i < count($associations) - 1; ++$i) {
                    if (false === $this->isTableRelation($metadata, $associations[$i] . '.' . $associations[$i + 1])) {
                        break;
                    }
                    $queryBuilder->innerJoin(chr($previousId) . '.' . $associations[$i], chr($previousId + 1));
                    ++$previousId;
                    foreach ($metadata->getAssociationMappings() as $associationMapping) {
                        if ($associationMapping['fieldName'] === $associations[$i]) {
                            $metadata = $this->manager->getClassMetadata($associationMapping['targetEntity']);
                        }
                    }
                    unset($fields[$i]);
                }
                $fields = implode('.', $fields);

                return [
                    chr($previousId), $fields,
                ];
            }

            return [
                chr($previousId),
            ];
        }
    }

    /**
     * Removes the duplicate joins of given query builder.
     *
     * @param DoctrineQueryBuilder $queryBuilder The query builder
     *
     * @return DoctrineQueryBuilder
     */
    private function removeDuplicateJoins(DoctrineQueryBuilder $queryBuilder)
    {
        if (empty($queryBuilder->getDQLParts()['join'])) {
            return $queryBuilder;
        }
        $joinArray = [];
        $joins = $queryBuilder->getDQLParts()['join']['a'];
        foreach ($joins as $join) {
            $joinArray[] = $join->getAlias();
        }
        $joinArray = array_unique($joinArray);
        foreach ($joins as $key => $join) {
            if (!array_key_exists($key, $joinArray)) {
                unset($joins[$key]);
            }
        }

        $queryBuilder->resetDQLPart('join');
        foreach ($joins as $join) {
            $queryBuilder->join($join->getJoin(), $join->getAlias());
        }

        return $queryBuilder;
    }
}
