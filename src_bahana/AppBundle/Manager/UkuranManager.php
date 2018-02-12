<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Ukuran;
use AppBundle\Repository\UkuranRepository;
use Doctrine\ORM\EntityManager;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\DiExtraBundle\Annotation\InjectParams;
use JMS\DiExtraBundle\Annotation\Service;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Service(id="manager.ukuran")
 */
class UkuranManager
{
    /**
     * @var EntityManager
     */
    private $entityManager;

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

        $this->ukuranRepository = $this->entityManager->getRepository("AppBundle:Ukuran");
    }

    public function assignRequest(Ukuran $ukuran, Request $request)
    {
        if (!is_null($request->request->get('nama')) && $request->request->get('nama') != '') {
            $ukuran->setNama($request->request->get('nama'));
        }
        if (is_null($request->request->get('aktif'))) {
            $ukuran->setAktif(false);
        } else {
            $ukuran->setAktif($request->request->get('aktif') == 'true');
        }
    }

    public function findAllAktif()
    {
        $query = $this->ukuranRepository->queryAktif();
        $query = $this->ukuranRepository->queryOrderByNamaASC($query)->getQuery();

        return $query->getResult();
    }

    public function findAll()
    {
        $query = $this->ukuranRepository->query();
        $query = $this->ukuranRepository->queryOrderByNamaASC($query)->getQuery();

        return $query->getResult();
    }

    public function findOneById($id)
    {
        $query = $this->ukuranRepository->queryById($id)->getQuery();

        return $query->getOneOrNullResult();
    }

    public function remove(Ukuran $ukuran)
    {
        $this->entityManager->remove($ukuran);
        $this->entityManager->flush();
    }

    public function save(Ukuran $ukuran)
    {
        $this->entityManager->persist($ukuran);
        $this->entityManager->flush();
    }
}
