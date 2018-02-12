<?php

namespace AppBundle\Manager;

use AppBundle\Entity\HargaOTR;
use AppBundle\Entity\Kendaraan;
use AppBundle\Entity\Kota;
use AppBundle\Repository\HargaOTRRepository;
use AppBundle\Repository\KendaraanRepository;
use AppBundle\Repository\KotaRepository;
use Doctrine\ORM\EntityManager;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\DiExtraBundle\Annotation\InjectParams;
use JMS\DiExtraBundle\Annotation\Service;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Service(id="manager.hargaOTR")
 */
class HargaOTRManager
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var HargaOTRRepository
     */
    private $hargaOTRRepository;

    /**
     * @var KotaRepository
     */
    private $kotaRepository;

    /**
     * @var KendaraanRepository
     */
    private $kendaraanRepository;

    /**
     * @InjectParams({
     *      "entityManager" = @Inject("doctrine.orm.default_entity_manager")
     * })
     */
    function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

        $this->hargaOTRRepository  = $this->entityManager->getRepository("AppBundle:HargaOTR");
        $this->kotaRepository      = $this->entityManager->getRepository("AppBundle:Kota");
        $this->kendaraanRepository = $this->entityManager->getRepository("AppBundle:Kendaraan");
    }

    public function assignRequest(HargaOTR $hargaOTR, Request $request)
    {
        if (!is_null($request->request->get('harga')) && $request->request->get('harga') != '') {
            $hargaOTR->setHarga($request->request->get('harga'));
        }
        if (!is_null($request->request->get('kota')) && $request->request->get('kota') != '') {
            $kota = $this->kotaRepository->queryById($request->request->get('kota'))->getQuery()->getOneOrNullResult();
            if ($kota instanceof Kota) {
                $hargaOTR->setKota($kota);
            }
        }
        if (!is_null($request->request->get('kendaraan')) && $request->request->get('kendaraan') != '') {
            $kendaraan = $this->kendaraanRepository->queryById($request->request->get('kendaraan'))->getQuery()->getOneOrNullResult();
            if ($kendaraan instanceof Kendaraan) {
                $hargaOTR->setKendaraan($kendaraan);
            }
        }
    }

    public function findAll()
    {
        $query = $this->hargaOTRRepository->query()->getQuery();

        return $query->getResult();
    }

    public function findAllByKotaId($kotaId)
    {
        $query = $this->hargaOTRRepository->queryByKotaId($kotaId)->getQuery();

        return $query->getResult();
    }

    public function findAllByKendaraanId($kendaraanId)
    {
        $query = $this->hargaOTRRepository->queryByKendaraanId($kendaraanId)->getQuery();

        return $query->getResult();
    }

    public function findOneById($id)
    {
        $query = $this->hargaOTRRepository->queryById($id)->getQuery();

        return $query->getOneOrNullResult();
    }

    public function findOneByKotaIdAndKendaraanId($kotaId, $kenadraanId)
    {
        $query = $this->hargaOTRRepository->queryByKotaIdAndKendaraanId($kotaId, $kenadraanId)->getQuery();

        return $query->getOneOrNullResult();
    }

    public function remove(HargaOTR $hargaOTR)
    {
        $this->entityManager->remove($hargaOTR);
        $this->entityManager->flush();
    }

    public function save(HargaOTR $hargaOTR)
    {
        $this->entityManager->persist($hargaOTR);
        $this->entityManager->flush();
    }
}
