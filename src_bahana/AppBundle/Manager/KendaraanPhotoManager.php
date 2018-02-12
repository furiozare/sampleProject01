<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Kendaraan;
use AppBundle\Entity\KendaraanPhoto;
use AppBundle\Repository\KendaraanPhotoRepository;
use AppBundle\Repository\KendaraanRepository;
use Doctrine\ORM\EntityManager;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\DiExtraBundle\Annotation\InjectParams;
use JMS\DiExtraBundle\Annotation\Service;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Service(id="manager.kendaraanPhoto")
 */
class KendaraanPhotoManager
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var KendaraanPhotoRepository
     */
    private $kendaraanPhotoRepository;

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

        $this->kendaraanPhotoRepository = $this->entityManager->getRepository("AppBundle:KendaraanPhoto");
        $this->kendaraanRepository      = $this->entityManager->getRepository("AppBundle:Kendaraan");
    }

    public function assignRequest(KendaraanPhoto $kendaraanPhoto, Request $request)
    {
        if (!is_null($request->files->get('file'))) {
            $kendaraanPhoto->setFile($request->files->get('file'));
        }
        if (!is_null($request->request->get('kendaraan')) && $request->request->get('kendaraan') != '') {
            $kendaraan = $this->kendaraanRepository->queryById($request->request->get('kendaraan'))->getQuery()->getOneOrNullResult();
            if ($kendaraan instanceof Kendaraan) {
                $kendaraanPhoto->setKendaraan($kendaraan);
            }
        }
    }

    public function findAll()
    {
        $query = $this->kendaraanPhotoRepository->query()->getQuery();

        return $query->getResult();
    }

    public function findByKendaraanId($kendaraanId)
    {
        $query = $this->kendaraanPhotoRepository->queryByKendaraanId($kendaraanId)->getQuery();

        return $query->getResult();
    }

    public function findOneById($id)
    {
        $query = $this->kendaraanPhotoRepository->queryById($id)->getQuery();

        return $query->getOneOrNullResult();
    }

    public function remove(KendaraanPhoto $kendaraanPhoto)
    {
        $this->entityManager->remove($kendaraanPhoto);
        $this->entityManager->flush();
    }

    public function save(KendaraanPhoto $kendaraanPhoto)
    {
        $this->entityManager->persist($kendaraanPhoto);
        $this->entityManager->flush();
    }
}
