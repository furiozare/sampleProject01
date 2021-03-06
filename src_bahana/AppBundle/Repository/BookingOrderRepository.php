<?php

namespace AppBundle\Repository;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\QueryBuilder;

/**
 * BookingOrderRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BookingOrderRepository extends \Doctrine\ORM\EntityRepository
{
    private $alias = 'bookOrd';

    public function query(QueryBuilder $queryBuilder = null)
    {
        if (is_null($queryBuilder)) {
            $queryBuilder = $this->createQueryBuilder($this->alias);
        }

        return $queryBuilder;
    }

    public function queryById($id, QueryBuilder $queryBuilder = null)
    {
        if (is_null($queryBuilder)) {
            $queryBuilder = $this->createQueryBuilder($this->alias);
        }

        return $queryBuilder->andWhere($queryBuilder->expr()->eq($this->alias . '.id', ':id'))
            ->setParameter(':id', $id);
    }

    public function queryByDateRange($startDate, $endDate, QueryBuilder $queryBuilder = null)
    {
        if (is_null($queryBuilder)) {
            $queryBuilder = $this->createQueryBuilder($this->alias);
        }

        return $queryBuilder
            ->andWhere($queryBuilder->expr()->gte($this->alias . ".createdAt", ':createdAtUp'))
            ->andWhere($queryBuilder->expr()->lte($this->alias . ".createdAt", ':createdAtDown'))
            ->setParameter(':createdAtUp', date('Y-m-d 00:00:00', strtotime($startDate)))
            ->setParameter(':createdAtDown', date('Y-m-d 23:59:59', strtotime($endDate)))
            ->addOrderBy($this->alias . '.createdAt', Criteria::DESC);
    }

    public function queryByKendaraanId($kendaraanId, QueryBuilder $queryBuilder = null)
    {
        if (is_null($queryBuilder)) {
            $queryBuilder = $this->createQueryBuilder($this->alias);
        }

        return $queryBuilder
            ->leftJoin($this->alias . '.kendaraanWarna', 'kendaraanWarna')
            ->andWhere($queryBuilder->expr()->gte("kendaraanWarna.kendaraan", ':kendaraanId'))
            ->setParameter(':kendaraanId', $kendaraanId);
    }
}
