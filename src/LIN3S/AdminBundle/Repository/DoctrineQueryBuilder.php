<?php

/*
 * This file is part of the Admin Bundle.
 *
 * Copyright (c) 2015-present LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\AdminBundle\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\QueryBuilder;
use LIN3S\AdminBundle\Configuration\Model\Entity;
use LIN3S\AdminBundle\Configuration\Model\ListField;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 * @author Jagoba Perez <jagoba@lin3s.com>
 * @author Beñat Espiña <benatespina@gmail.com>
 */
final class DoctrineQueryBuilder
{
    private $manager;

    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
    }

    public function generate(Request $request, Entity $config)
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

        if (null !== $alias) {
            null === $fields
                ? $queryBuilder->addOrderBy($alias . '.' . $request->get('orderBy'), $request->get('order', 'ASC'))
                : $queryBuilder->addOrderBy($alias . '.' . $fields, $request->get('order', 'ASC'));
        } else {
            $queryBuilder = $this->addDefaultOrderBy($queryBuilder, $request, $config, 'a');
        }

        list($alias, $fields) = $this->getQueryAliasAndFields(
            $request->get('filterBy'),
            $request->get('filter'),
            $metadata,
            $queryBuilder
        );

        if (null !== $alias) {
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
     * @param Entity        $config   The entity configuration
     * @param ClassMetadata $metadata The class metadata
     *
     * @return array
     */
    private function resolveAssociations(Entity $config, ClassMetadata $metadata)
    {
        $associations = [];
        foreach ($metadata->getAssociationMappings() as $associationMapping) {
            $fieldName = $associationMapping['fieldName'];
            $fieldClass = array_filter($config->listFields(), function (ListField $field) use ($fieldName) {
                if (!isset($field->options()['field'])) {
                    return;
                }

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
     * @param string        $criteriaBy   The criteria key
     * @param string        $criteria     The criteria value
     * @param ClassMetadata $metadata     The Doctrine class metadata
     * @param QueryBuilder  $queryBuilder The query builder
     *
     * @return array
     */
    private function getQueryAliasAndFields(
        $criteriaBy,
        $criteria,
        ClassMetadata $metadata,
        QueryBuilder $queryBuilder
    ) {
        $alias = null;
        $fields = null;

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
                $alias = chr($previousId);
                $fields = implode('.', $fields);
            } else {
                $alias = chr($previousId);
            }
        }

        return [
            $alias,
            $fields,
        ];
    }

    /**
     * Removes the duplicate joins of given query builder.
     *
     * @param QueryBuilder $queryBuilder The query builder
     *
     * @return QueryBuilder
     */
    private function removeDuplicateJoins(QueryBuilder $queryBuilder)
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

    private function addDefaultOrderBy(
        QueryBuilder $queryBuilder,
        Request $request,
        Entity $config,
        $alias = null
    ) {
        if (false === $request->query->has('orderBy') && false === empty($config->listOrderByDefault())) {
            $sort = key($config->listOrderByDefault());

            $queryBuilder->orderBy(
                null === $alias ? $sort : $alias . '.' . $sort,
                $config->listOrderByDefault()[$sort]
            );
        }

        return $queryBuilder;
    }
}
