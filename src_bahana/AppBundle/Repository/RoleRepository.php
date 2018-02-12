<?php

namespace AppBundle\Repository;

use Doctrine\ORM\QueryBuilder;

/**
 * RoleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RoleRepository extends \Doctrine\ORM\EntityRepository
{
    private $alias = "rl";

    public function queryFindById($id, QueryBuilder $query = null)
    {
        if (is_null($query)) {
            $query = $this->createQueryBuilder($this->alias);
        }

        return $query->andWhere($query->expr()->eq($this->alias . '.id', ':id'))
            ->setParameter(':id', $id);
    }

    public function queryFindBySymName($id, QueryBuilder $query = null)
    {
        if (is_null($query)) {
            $query = $this->createQueryBuilder($this->alias);
        }

        return $query->andWhere($query->expr()->eq($this->alias . '.symName', ':symName'))
            ->setParameter(':symName', $id);
    }

    public function queryFindAllSuperAdmin(QueryBuilder $query = null)
    {
        if (is_null($query)) {
            $query = $this->createQueryBuilder($this->alias);
        }

        return $query;
    }

    public function queryFindAll(QueryBuilder $query = null)
    {
        if (is_null($query)) {
            $query = $this->createQueryBuilder($this->alias);
        }

        return $query->andWhere($query->expr()->neq($this->alias . '.id', ':id'))
            ->setParameter(':id', 1);
    }
}