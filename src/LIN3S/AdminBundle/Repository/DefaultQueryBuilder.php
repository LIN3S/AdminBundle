<?php

namespace LIN3S\AdminBundle\Repository;

use Doctrine\ORM\EntityManager;
use LIN3S\AdminBundle\Configuration\EntityConfiguration;
use Symfony\Component\HttpFoundation\Request;

class DefaultQueryBuilder implements QueryBuilder
{
    protected $manager;

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

        foreach ($associations as $association) {
            $queryBuilder->join('a.' . $association, 'join_' . $association);
        }


        if ($request->get('orderBy')) {
            $possibleAssociation = explode(".", $request->get('orderBy'))[0];

            $found = false;
            foreach ($metadata->associationMappings as $associationMapping) {
                if ($possibleAssociation === $associationMapping['fieldName']) {
                    $queryBuilder->addOrderBy(
                        'join_' . $associationMapping['fieldName'] . '.' . explode(".", $request->get('orderBy'))[1],
                        $request->get('order', 'ASC')
                    );
                    $found = true;
                    continue;
                }
            }

            if (!$found) {
                $queryBuilder->addOrderBy('a.' . $request->get('orderBy'), $request->get('order', 'ASC'));
            }
        }

        if ($request->get('filterBy') && $request->get('filter')) {
            $association = explode(".", $request->get('filterBy'))[0];
            if (in_array($association, $associations)) {
                $queryBuilder->where($queryBuilder->expr()->like(
                    'join_' . $request->get('filterBy'), "'%" . $request->get('filter') . "%'"
                ));
            } else {
                $queryBuilder->where($queryBuilder->expr()->like(
                    'a.' . $request->get('filterBy'), "'%" . $request->get('filter') . "%'"
                ));
            }
        }

        return $queryBuilder;
    }

    private function resolveAssociations(EntityConfiguration $config, $metadata)
    {
        $associations = [];
        foreach ($metadata->associationMappings as $associationMapping) {
            $fieldName = $associationMapping['fieldName'];
            $fieldClass = array_filter($config->listFields(), function ($field) use ($fieldName) {
                return $fieldName === explode(".", $field->options()['field'])[0];
            });

            if (count($fieldClass) > 0) {
                $associations[] = $fieldName;

            }
        }

        return $associations;
    }

}
