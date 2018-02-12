<?php

namespace AppBundle\Manager;

use AppBundle\Entity\PartUkuran;
use AppBundle\Entity\Ukuran;
use AppBundle\Repository\PartUkuranRepository;
use AppBundle\Repository\UkuranRepository;
use Doctrine\ORM\EntityManager;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\DiExtraBundle\Annotation\InjectParams;
use JMS\DiExtraBundle\Annotation\Service;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Service(id="manager.partUkuran")
 */
class PartUkuranManager
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var PartUkuranRepository
     */
    private $partUkuranRepository;

    /**
     * @var UkuranRepository
     */
    private $ukuranRepository;

    /**
     * @InjectParams({
     *      "entityManager" = @Inject("doctrine.orm.default_entity_manager")
     * })
     */
    function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

        $this->partUkuranRepository = $this->entityManager->getRepository("AppBundle:PartUkuran");
        $this->ukuranRepository     = $this->entityManager->getRepository("AppBundle:Ukuran");
    }

    public function assignRequest(PartUkuran $partUkuran, Request $request)
    {
        if (!is_null($request->request->get('ukuran')) && $request->request->get('ukuran') != '') {
            $ukuran = $this->ukuranRepository->queryById($request->request->get('ukuran'))->getQuery()->getOneOrNullResult();
            if ($ukuran instanceof Ukuran) {
                $partUkuran->setUkuran($ukuran);
            }
        }
    }

    public function findAll()
    {
        $query = $this->partUkuranRepository->query()->getQuery();

        return $query->getResult();
    }

    public function findAllByPartId($partId)
    {
        $query = $this->partUkuranRepository->queryByPartId($partId)->getQuery();

        return $query->getResult();
    }

    public function findOneById($id)
    {
        $query = $this->partUkuranRepository->queryById($id)->getQuery();

        return $query->getOneOrNullResult();
    }

    public function remove(PartUkuran $partUkuran)
    {
        $this->entityManager->remove($partUkuran);
        $this->entityManager->flush();
    }

    public function save(PartUkuran $partUkuran)
    {
        $this->entityManager->persist($partUkuran);
        $this->entityManager->flush();
    }
}
