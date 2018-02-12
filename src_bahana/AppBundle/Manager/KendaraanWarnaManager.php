<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Kendaraan;
use AppBundle\Entity\KendaraanWarna;
use AppBundle\Entity\Warna;
use AppBundle\Repository\KendaraanRepository;
use AppBundle\Repository\KendaraanWarnaRepository;
use AppBundle\Repository\WarnaRepository;
use Doctrine\ORM\EntityManager;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\DiExtraBundle\Annotation\InjectParams;
use JMS\DiExtraBundle\Annotation\Service;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Service(id="manager.kendaraanWarna")
 */
class KendaraanWarnaManager
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var KendaraanWarnaRepository
     */
    private $kendaraanWarnaRepository;

    /**
     * @var KendaraanRepository
     */
    private $kendaraanRepository;

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

        $this->kendaraanWarnaRepository = $this->entityManager->getRepository("AppBundle:KendaraanWarna");
        $this->kendaraanRepository      = $this->entityManager->getRepository("AppBundle:Kendaraan");
        $this->warnaRepository          = $this->entityManager->getRepository("AppBundle:Warna");
    }

    public function assignRequest(KendaraanWarna $kendaraanWarna, Request $request)
    {
        if (!is_null($request->request->get('kendaraan')) && $request->request->get('kendaraan') != '') {
            $kendaraan = $this->kendaraanRepository->queryById($request->request->get('kendaraan'))->getQuery()->getOneOrNullResult();
            if ($kendaraan instanceof Kendaraan) {
                $kendaraanWarna->setKendaraan($kendaraan);
            }
        }
        if (!is_null($request->request->get('warna')) && $request->request->get('warna') != '') {
            $warna = $this->warnaRepository->queryById($request->request->get('warna'))->getQuery()->getOneOrNullResult();
            if ($warna instanceof Warna) {
                $kendaraanWarna->setWarna($warna);
            }
        }
    }

    public function findAll()
    {
        $query = $this->kendaraanWarnaRepository->query()->getQuery();

        return $query->getResult();
    }

    public function findByKendaraanId($kendaraanId)
    {
        $query = $this->kendaraanWarnaRepository->queryByKendaraanId($kendaraanId)->getQuery();

        return $query->getResult();
    }

    public function findOneById($id)
    {
        $query = $this->kendaraanWarnaRepository->queryById($id)->getQuery();

        return $query->getOneOrNullResult();
    }

    public function remove(KendaraanWarna $kendaraanWarna)
    {
        $this->entityManager->remove($kendaraanWarna);
        $this->entityManager->flush();
    }

    public function save(KendaraanWarna $kendaraanWarna)
    {
        $this->entityManager->persist($kendaraanWarna);
        $this->entityManager->flush();
    }
}
