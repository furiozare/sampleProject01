<?php

namespace AppBundle\Manager;

use AppBundle\Entity\ArtikelEmail;
use AppBundle\Repository\ArtikelEmailRepository;
use Doctrine\ORM\EntityManager;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\DiExtraBundle\Annotation\InjectParams;
use JMS\DiExtraBundle\Annotation\Service;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Service(id="manager.artikelEmail")
 */
class ArtikelEmailManager
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var ArtikelEmailRepository
     */
    private $artikelEmailRepository;

    /**
     * @InjectParams({
     *      "entityManager" = @Inject("doctrine.orm.default_entity_manager")
     * })
     */
    function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

        $this->artikelEmailRepository = $this->entityManager->getRepository("AppBundle:ArtikelEmail");
    }

    public function assignRequest(ArtikelEmail $artikelEmail, Request $request)
    {
    }

    public function findAll()
    {
        $query = $this->artikelEmailRepository->query()->getQuery();

        return $query->getResult();
    }

    public function findBlastedEmailArrayByArtikel($artikelId)
    {
        $query = $this->artikelEmailRepository->queryByArtikelId($artikelId);
        $query = $this->artikelEmailRepository->queryBlastedArray($query);

        return $query->getQuery()->getResult();
    }

    public function findOneById($id)
    {
        $query = $this->artikelEmailRepository->queryById($id)->getQuery();

        return $query->getOneOrNullResult();
    }

    public function remove(ArtikelEmail $artikelEmail)
    {
        $this->entityManager->remove($artikelEmail);
        $this->entityManager->flush();
    }

    public function save(ArtikelEmail $artikelEmail)
    {
        if (!$artikelEmail->getId()) {
            $this->entityManager->persist($artikelEmail);
        }
        $this->entityManager->flush();
    }
}
