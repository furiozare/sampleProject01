<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Warna;
use AppBundle\Repository\WarnaRepository;
use Doctrine\ORM\EntityManager;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\DiExtraBundle\Annotation\InjectParams;
use JMS\DiExtraBundle\Annotation\Service;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Service(id="manager.warna")
 */
class WarnaManager
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var WarnaRepository
     */
    private $warnaRepository;

    /**
     * @InjectParams({
     *      "entityManager" = @Inject("doctrine.orm.default_entity_manager")
     * })
     */
    function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

        $this->warnaRepository = $this->entityManager->getRepository("AppBundle:Warna");
    }

    public function assignRequest(Warna $warna, Request $request)
    {
        if (!is_null($request->files->get('file'))) {
            $warna->setFile($request->files->get('file'));
        }
        if (!is_null($request->request->get('nama')) && $request->request->get('nama') != '') {
            $warna->setNama($request->request->get('nama'));
        }
        if (is_null($request->request->get('aktif'))) {
            $warna->setAktif(false);
        } else {
            $warna->setAktif(true);
        }
    }

    public function findAllAktif()
    {
        $query = $this->warnaRepository->queryAktif()->getQuery();

        return $query->getResult();
    }

    public function findAll()
    {
        $query = $this->warnaRepository->query()->getQuery();

        return $query->getResult();
    }

    public function findOneById($id)
    {
        $query = $this->warnaRepository->queryById($id)->getQuery();

        return $query->getOneOrNullResult();
    }

    public function remove(Warna $warna)
    {
        $this->entityManager->remove($warna);
        $this->entityManager->flush();
    }

    public function save(Warna $warna)
    {
        $this->entityManager->persist($warna);
        $this->entityManager->flush();
    }
}
