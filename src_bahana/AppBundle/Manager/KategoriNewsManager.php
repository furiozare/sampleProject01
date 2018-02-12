<?php

namespace AppBundle\Manager;

use AppBundle\Entity\KategoriNews;
use AppBundle\Repository\KategoriNewsRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\DiExtraBundle\Annotation\InjectParams;
use JMS\DiExtraBundle\Annotation\Service;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Service(id="manager.kategoriNews")
 */
class KategoriNewsManager
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var KategoriNewsRepository
     */
    private $kategoriNewsRepository;

    /**
     * @InjectParams({
     *      "entityManager" = @Inject("doctrine.orm.default_entity_manager")
     * })
     */
    function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

        $this->kategoriNewsRepository = $this->entityManager->getRepository("AppBundle:KategoriNews");
    }

    public function assignRequest(KategoriNews $kategoriNews, Request $request)
    {
        if (!is_null($request->request->get('nama'))) {
            $nama = trim($request->request->get('nama'));
            if ($nama != "") {
                $kategoriNews->setNama($request->request->get('nama'));
            } else {
                $kategoriNews->setNama(null);
            }
        }
        if (is_null($request->request->get('aktif'))) {
            $kategoriNews->setAktif(false);
        } else {
            $kategoriNews->setAktif($request->request->get('aktif') == "true");
        }
    }

    public function findAllAktif()
    {
        $query = $this->kategoriNewsRepository->queryAktif();
        $query = $this->kategoriNewsRepository->queryOrderByNama(Criteria::ASC, $query)->getQuery();

        return $query->getResult();
    }

    public function findAll()
    {
        $query = $this->kategoriNewsRepository->queryOrderByNama(Criteria::ASC)->getQuery();

        return $query->getResult();
    }

    public function findOneById($id)
    {
        $query = $this->kategoriNewsRepository->queryById($id)->getQuery();

        return $query->getOneOrNullResult();
    }

    public function remove(KategoriNews $kategoriNews)
    {
        $this->entityManager->remove($kategoriNews);
        $this->entityManager->flush();
    }

    public function save(KategoriNews $kategoriNews)
    {
        $this->entityManager->persist($kategoriNews);
        $this->entityManager->flush();
    }
}
