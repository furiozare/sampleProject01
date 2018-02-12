<?php

namespace AppBundle\Manager;

use AppBundle\Entity\KategoriPart;
use AppBundle\Repository\KategoriPartRepository;
use Doctrine\ORM\EntityManager;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\DiExtraBundle\Annotation\InjectParams;
use JMS\DiExtraBundle\Annotation\Service;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Service(id="manager.kategoriPart")
 */
class KategoriPartManager
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var KategoriPartRepository
     */
    private $kategoriPartRepository;

    /**
     * @InjectParams({
     *      "entityManager" = @Inject("doctrine.orm.default_entity_manager")
     * })
     */
    function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

        $this->kategoriPartRepository = $this->entityManager->getRepository("AppBundle:KategoriPart");
    }

    public function assignRequest(KategoriPart $kategoriPart, Request $request)
    {
        if (!is_null($request->files->get('file'))) {
            $kategoriPart->setFile($request->files->get('file'));
        }
        if (!is_null($request->request->get('nama')) && $request->request->get('nama') != '') {
            $kategoriPart->setNama($request->request->get('nama'));
        }
        if (is_null($request->request->get('aktif'))) {
            $kategoriPart->setAktif(false);
        } else {
            $kategoriPart->setAktif($request->request->get('aktif') == 'true');
        }
    }

    public function findAllAktif()
    {
        $query = $this->kategoriPartRepository->queryAktif();
        $query = $this->kategoriPartRepository->queryOrderByNamaASC($query)->getQuery();

        return $query->getResult();
    }

    public function findAll()
    {
        $query = $this->kategoriPartRepository->query();
        $query = $this->kategoriPartRepository->queryOrderByNamaASC($query)->getQuery();

        return $query->getResult();
    }

    public function findOneById($id)
    {
        $query = $this->kategoriPartRepository->queryById($id)->getQuery();

        return $query->getOneOrNullResult();
    }

    public function remove(KategoriPart $kategoriPart)
    {
        $this->entityManager->remove($kategoriPart);
        $this->entityManager->flush();
    }

    public function save(KategoriPart $kategoriPart)
    {
        $this->entityManager->persist($kategoriPart);
        $this->entityManager->flush();
    }
}
