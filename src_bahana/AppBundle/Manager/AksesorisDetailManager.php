<?php

namespace AppBundle\Manager;

use AppBundle\Entity\AksesorisDetail;
use AppBundle\Entity\Warna;
use AppBundle\Repository\AksesorisDetailRepository;
use AppBundle\Repository\WarnaRepository;
use Doctrine\ORM\EntityManager;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\DiExtraBundle\Annotation\InjectParams;
use JMS\DiExtraBundle\Annotation\Service;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Service(id="manager.aksesorisDetail")
 */
class AksesorisDetailManager
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var AksesorisDetailRepository
     */
    private $aksesorisDetailRepository;

    /**
     * @var WarnaRepository
     */
    private $warnaRepository;

    /**
     * @InjectParams({
     *      "entityManager" = @Inject("doctrine.orm.default_entity_manager")
     * })
     */
    function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

        $this->aksesorisDetailRepository = $this->entityManager->getRepository("AppBundle:AksesorisDetail");
        $this->warnaRepository           = $this->entityManager->getRepository("AppBundle:Warna");
    }

    public function assignRequest(AksesorisDetail $aksesorisDetail, Request $request)
    {
        if (!is_null($request->request->get('kode')) && $request->request->get('kode') != '') {
            $aksesorisDetail->setKode($request->request->get('kode'));
        }
        if (!is_null($request->request->get('warna')) && $request->request->get('warna') != '') {
            $warna = $this->warnaRepository->queryById($request->request->get('warna'))->getQuery()->getOneOrNullResult();
            if ($warna instanceof Warna) {
                $aksesorisDetail->setWarna($warna);
            }
        }
    }

    public function findAll()
    {
        $query = $this->aksesorisDetailRepository->query()->getQuery();

        return $query->getResult();
    }

    public function findAllByAksesorisId($aksesorisId)
    {
        $query = $this->aksesorisDetailRepository->queryByAksesorisId($aksesorisId)->getQuery();

        return $query->getResult();
    }

    public function findOneById($id)
    {
        $query = $this->aksesorisDetailRepository->queryById($id)->getQuery();

        return $query->getOneOrNullResult();
    }

    public function remove(AksesorisDetail $aksesorisDetail)
    {
        $this->entityManager->remove($aksesorisDetail);
        $this->entityManager->flush();
    }

    public function save(AksesorisDetail $aksesorisDetail)
    {
        $this->entityManager->persist($aksesorisDetail);
        $this->entityManager->flush();
    }
}
