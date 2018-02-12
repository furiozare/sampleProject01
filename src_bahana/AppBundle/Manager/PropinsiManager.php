<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Propinsi;
use AppBundle\Repository\PropinsiRepository;
use Doctrine\ORM\EntityManager;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\DiExtraBundle\Annotation\InjectParams;
use JMS\DiExtraBundle\Annotation\Service;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Service(id="manager.propinsi")
 */
class PropinsiManager
{
    /**
     * @var EntityManager
     */
    private $entityManager;

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

        $this->propinsiRepository = $this->entityManager->getRepository("AppBundle:Propinsi");
    }

    public function assignRequest(Propinsi $propinsi, Request $request)
    {
        if (!is_null($request->request->get('nama')) && $request->request->get('nama') != '') {
            $propinsi->setNama($request->request->get('nama'));
        }
        if (is_null($request->request->get('aktif'))) {
            $propinsi->setAktif(false);
        } else {
            $propinsi->setAktif(true);
        }
    }

    public function findAllAktif()
    {
        $query = $this->propinsiRepository->queryAktif();
        $query = $this->propinsiRepository->queryOrderByNamaASC($query)->getQuery();

        return $query->getResult();
    }

    public function findAll()
    {
        $query = $this->propinsiRepository->query();
        $query = $this->propinsiRepository->queryOrderByNamaASC($query)->getQuery();

        return $query->getResult();
    }

    public function findOneById($id)
    {
        $query = $this->propinsiRepository->queryById($id)->getQuery();

        return $query->getOneOrNullResult();
    }

    public function remove(Propinsi $propinsi)
    {
        $this->entityManager->remove($propinsi);
        $this->entityManager->flush();
    }

    public function save(Propinsi $propinsi)
    {
        $this->entityManager->persist($propinsi);
        $this->entityManager->flush();
    }
}
