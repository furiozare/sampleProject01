<?php

namespace AppBundle\Manager;

use AppBundle\Entity\KategoriPart;
use AppBundle\Entity\Part;
use AppBundle\Repository\KategoriPartRepository;
use AppBundle\Repository\PartRepository;
use Doctrine\ORM\EntityManager;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\DiExtraBundle\Annotation\InjectParams;
use JMS\DiExtraBundle\Annotation\Service;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Service(id="manager.part")
 */
class PartManager
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var PartRepository
     */
    private $partRepository;

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

        $this->partRepository         = $this->entityManager->getRepository("AppBundle:Part");
        $this->kategoriPartRepository = $this->entityManager->getRepository("AppBundle:KategoriPart");
    }

    public function assignRequest(Part $part, Request $request)
    {
        if (!is_null($request->request->get('nama')) && $request->request->get('nama') != '') {
            $part->setNama($request->request->get('nama'));
        }
        if (!is_null($request->request->get('harga')) && $request->request->get('harga') != '') {
            $part->setHarga($request->request->get('harga'));
        }
        if (!is_null($request->request->get('berat')) && $request->request->get('berat') != '') {
            $part->setBerat($request->request->get('berat'));
        }
        if (!is_null($request->request->get('deskripsi')) && $request->request->get('deskripsi') != '') {
            $part->setDeskripsi($request->request->get('deskripsi'));
        }
        if (is_null($request->request->get('aktif'))) {
            $part->setAktif(false);
        } else {
            $part->setAktif(true);
        }
        if (!is_null($request->request->get('kategoriPart')) && $request->request->get('kategoriPart') != '') {
            $kategoriPart = $this->kategoriPartRepository->queryById($request->request->get('kategoriPart'))->getQuery()->getOneOrNullResult();
            if ($kategoriPart instanceof KategoriPart) {
                $part->setKategoriPart($kategoriPart);
            }
        }
    }

    public function findAllAktif()
    {
        $query = $this->partRepository->queryAktif()->getQuery();

        return $query->getResult();
    }

    public function findAllAktifByKategoriPartId($kategoriPartId)
    {
        $query = $this->partRepository
            ->queryAktif(
                $this->partRepository->queryByKategoriPartId($kategoriPartId)
            )
            ->getQuery();

        return $query->getResult();
    }

    public function findAll()
    {
        $query = $this->partRepository->query()->getQuery();

        return $query->getResult();
    }

    public function findOneById($id)
    {
        $query = $this->partRepository->queryById($id)->getQuery();

        return $query->getOneOrNullResult();
    }

    public function remove(Part $part)
    {
        $this->entityManager->remove($part);
        $this->entityManager->flush();
    }

    public function save(Part $part)
    {
        $this->entityManager->persist($part);
        $this->entityManager->flush();
    }
}
