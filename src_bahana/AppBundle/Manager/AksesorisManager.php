<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Aksesoris;
use AppBundle\Repository\AksesorisRepository;
use Doctrine\ORM\EntityManager;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\DiExtraBundle\Annotation\InjectParams;
use JMS\DiExtraBundle\Annotation\Service;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Service(id="manager.aksesoris")
 */
class AksesorisManager
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var AksesorisRepository
     */
    private $aksesorisRepository;

    /**
     * @InjectParams({
     *      "entityManager" = @Inject("doctrine.orm.default_entity_manager")
     * })
     */
    function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

        $this->aksesorisRepository = $this->entityManager->getRepository("AppBundle:Aksesoris");
    }

    public function assignRequest(Aksesoris $aksesoris, Request $request)
    {
        if (!is_null($request->request->get('nama')) && $request->request->get('nama') != '') {
            $aksesoris->setNama($request->request->get('nama'));
        }
        if (!is_null($request->request->get('harga')) && $request->request->get('harga') != '') {
            $aksesoris->setHarga($request->request->get('harga'));
        }
        if (is_null($request->request->get('aktif'))) {
            $aksesoris->setAktif(false);
        } else {
            $aksesoris->setAktif($request->request->get('aktif') == 'true');
        }
    }

    public function findAllAktif()
    {
        $query = $this->aksesorisRepository->queryAktif();
        $query = $this->aksesorisRepository->queryOrderByNamaASC($query)->getQuery();

        return $query->getResult();
    }

    public function findAll()
    {
        $query = $this->aksesorisRepository->query();
        $query = $this->aksesorisRepository->queryOrderByNamaASC($query)->getQuery();

        return $query->getResult();
    }

    public function findAllByKendaraanId($kendaraanId)
    {
        $query = $this->aksesorisRepository->queryByKendaraanId($kendaraanId);
        $query = $this->aksesorisRepository->queryOrderByNamaASC($query)->getQuery();

        return $query->getResult();
    }

    public function findAllAktifByKendaraanId($kendaraanId)
    {
        $query = $this->aksesorisRepository->queryAktif();
        $query = $this->aksesorisRepository->queryByKendaraanId($kendaraanId, $query);
        $query = $this->aksesorisRepository->queryOrderByNamaASC($query)->getQuery();

        return $query->getResult();
    }

    public function findOneById($id)
    {
        $query = $this->aksesorisRepository->queryById($id)->getQuery();

        return $query->getOneOrNullResult();
    }

    public function remove(Aksesoris $aksesoris)
    {
        $this->entityManager->remove($aksesoris);
        $this->entityManager->flush();
    }

    public function save(Aksesoris $aksesoris)
    {
        $this->entityManager->persist($aksesoris);
        $this->entityManager->flush();
    }
}
