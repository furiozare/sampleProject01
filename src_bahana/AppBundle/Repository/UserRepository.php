<?php

namespace AppBundle\Repository;

use Doctrine\ORM\QueryBuilder;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends \Doctrine\ORM\EntityRepository
{
    private $alias = "usr";

    public function queryFindById($id, QueryBuilder $query = null)
    {
        if (is_null($query)) {
            $query = $this->createQueryBuilder($this->alias);
        }

        return $query->andWhere($query->expr()->eq($this->alias . '.id', ':id'))
            ->setParameter(':id', $id);
    }

    public function queryFindByUsername($username, QueryBuilder $query = null)
    {
        if (is_null($query)) {
            $query = $this->createQueryBuilder($this->alias);
        }

        return $query->andWhere($query->expr()->eq($this->alias . '.username', ':username'))
            ->setParameter(':username', $username);
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

        return $query->andWhere($query->expr()->neq($this->alias . '.role_id', ':role_id'))
            ->setParameter(':role_id', 1);
    }
}
