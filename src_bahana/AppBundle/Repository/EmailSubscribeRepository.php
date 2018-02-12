<?php

namespace AppBundle\Repository;

use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;

/**
 * EmailSubscribeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EmailSubscribeRepository extends \Doctrine\ORM\EntityRepository
{
    private $alias = 'emailSubscribe';

    public function createQB(QueryBuilder $queryBuilder = null)
    {
        if (is_null($queryBuilder)) {
            $queryBuilder = $this->createQueryBuilder($this->alias);
        }

        return $queryBuilder;
    }

    public function query(QueryBuilder $queryBuilder = null)
    {
        $queryBuilder = $this->createQB($queryBuilder);

        return $queryBuilder;
    }

    public function queryByEmail($email, QueryBuilder $queryBuilder = null)
    {
        $queryBuilder = $this->createQB($queryBuilder);

        return $queryBuilder->andWhere($queryBuilder->expr()->eq($this->alias . '.email', ':email'))
            ->setParameter(':email', $email);
    }

    public function queryById($id, QueryBuilder $queryBuilder = null)
    {
        $queryBuilder = $this->createQB($queryBuilder);

        return $queryBuilder->andWhere($queryBuilder->expr()->eq($this->alias . '.id', ':id'))
            ->setParameter(':id', $id);
    }

    public function queryNotYetBlastedByArtikelId($artikelId, QueryBuilder $queryBuilder = null)
    {
        $queryBuilder = $this->createQB($queryBuilder);

        $queryBuilder = $queryBuilder->leftJoin(
            "$this->alias.artikelEmails", "artikelEmail",
            Join::WITH,
            $queryBuilder->expr()->eq("artikelEmail.artikel", ":artikelId")
        )
            ->setParameter(':artikelId', $artikelId)
            ->andWhere($queryBuilder->expr()->isNull("artikelEmail.id"));

        return $queryBuilder;
    }

    public function queryAktif(QueryBuilder $queryBuilder = null)
    {
        $queryBuilder = $this->createQB($queryBuilder);

        return $queryBuilder->andWhere($queryBuilder->expr()->eq($this->alias . '.aktif', ':aktif'))
            ->setParameter(':aktif', true);
    }
}