<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Kota;
use AppBundle\Entity\Propinsi;
use AppBundle\Repository\KotaRepository;
use AppBundle\Repository\PropinsiRepository;
use Doctrine\ORM\EntityManager;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\DiExtraBundle\Annotation\InjectParams;
use JMS\DiExtraBundle\Annotation\Service;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Service(id="manager.kota")
 */
class KotaManager
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var KotaRepository
     */
    private $kotaRepository;

    /**
     * @var PropinsiRepository
     */
    private $propinsiRepository;

    /**
     * @InjectParams({
     *      "entityManager" = @Inject("doctrine.orm.default_entity_manager")
     * })
     */
    function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

        $this->kotaRepository     = $this->entityManager->getRepository("AppBundle:Kota");
        $this->propinsiRepository = $this->entityManager->getRepository("AppBundle:Propinsi");
    }

    public function assignRequest(Kota $kota, Request $request)
    {
        if (!is_null($request->request->get('nama')) && $request->request->get('nama') != '') {
            $kota->setNama($request->request->get('nama'));
        }
        if (is_null($request->request->get('aktif'))) {
            $kota->setAktif(false);
        } else {
            $kota->setAktif(true);
        }
        if (!is_null($request->request->get('propinsi')) && $request->request->get('propinsi') != '') {
            $propinsi = $this->propinsiRepository->queryById($request->request->get('propinsi'))->getQuery()->getOneOrNullResult();
            if ($propinsi instanceof Propinsi) {
                $kota->setPropinsi($propinsi);
            }
        }
    }

    public function findAllAktif()
    {
        $query = $this->kotaRepository->queryAktif();
        $query = $this->kotaRepository->queryOrderByNamaASC($query)->getQuery();

        return $query->getResult();
    }

    public function findAll()
    {
        $query = $this->kotaRepository->query();
        $query = $this->kotaRepository->queryOrderByNamaASC($query)->getQuery();

        return $query->getResult();
    }

    public function findOneById($id)
    {
        $query = $this->kotaRepository->queryById($id)->getQuery();

        return $query->getOneOrNullResult();
    }

    public function remove(Kota $kota)
    {
        $this->entityManager->remove($kota);
        $this->entityManager->flush();
    }

    public function save(Kota $kota)
    {
        $this->entityManager->persist($kota);
        $this->entityManager->flush();
    }
}
