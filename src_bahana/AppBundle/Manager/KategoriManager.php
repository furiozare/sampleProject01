<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Kategori;
use AppBundle\Repository\KategoriRepository;
use Doctrine\ORM\EntityManager;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\DiExtraBundle\Annotation\InjectParams;
use JMS\DiExtraBundle\Annotation\Service;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Service(id="manager.kategori")
 */
class KategoriManager
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var KategoriRepository
     */
    private $kategoriRepository;

    /**
     * @InjectParams({
     *      "entityManager" = @Inject("doctrine.orm.default_entity_manager")
     * })
     */
    function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

        $this->kategoriRepository = $this->entityManager->getRepository("AppBundle:Kategori");
    }

    public function assignRequest(Kategori $kategori, Request $request)
    {
        if (!is_null($request->files->get('file'))) {
            $kategori->setFile($request->files->get('file'));
        }
        if (!is_null($request->request->get('nama')) && $request->request->get('nama') != '') {
            $kategori->setNama($request->request->get('nama'));
        }
        if (is_null($request->request->get('aktif'))) {
            $kategori->setAktif(false);
        } else {
            $kategori->setAktif(true);
        }
        if (is_null($request->request->get('kendaraan'))) {
            $kategori->setKendaraan(false);
        } else {
            $kategori->setKendaraan(true);
        }
    }

    public function findAllAktif()
    {
        $query = $this->kategoriRepository->queryAktif();
        $query = $this->kategoriRepository->queryOrderByNamaASC($query)->getQuery();

        return $query->getResult();
    }

    public function findAll()
    {
        $query = $this->kategoriRepository->query();
        $query = $this->kategoriRepository->queryOrderByNamaASC($query)->getQuery();

        return $query->getResult();
    }

    public function findOneById($id)
    {
        $query = $this->kategoriRepository->queryById($id)->getQuery();

        return $query->getOneOrNullResult();
    }

    public function remove(Kategori $kategori)
    {
        $this->entityManager->remove($kategori);
        $this->entityManager->flush();
    }

    public function save(Kategori $kategori)
    {
        $this->entityManager->persist($kategori);
        $this->entityManager->flush();
    }
}
