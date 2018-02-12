<?php

namespace AppBundle\Repository;

use Doctrine\ORM\QueryBuilder;

/**
 * AksesorisPhotoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AksesorisPhotoRepository extends \Doctrine\ORM\EntityRepository
{
    private $alias = 'aksespht';

    public function query(QueryBuilder $queryBuilder = null)
    {
        if (is_null($queryBuilder)) {
            $queryBuilder = $this->createQueryBuilder($this->alias);
        }

        return $queryBuilder;
    }

    public function queryByAksesorisId($aksesorisId, QueryBuilder $queryBuilder = null)
    {
        if (is_null($queryBuilder)) {
            $queryBuilder = $this->createQueryBuilder($this->alias);
        }

        return $queryBuilder->andWhere($queryBuilder->expr()->eq($this->alias . '.aksesoris', ':aksesorisId'))
            ->setParameter(':aksesorisId', $aksesorisId);
    }

    public function queryById($id, QueryBuilder $queryBuilder = null)
    {
        if (is_null($queryBuilder)) {
            $queryBuilder = $this->createQueryBuilder($this->alias);
        }

        return $queryBuilder->andWhere($queryBuilder->expr()->eq($this->alias . '.id', ':id'))
            ->setParameter(':id', $id);
    }
}
