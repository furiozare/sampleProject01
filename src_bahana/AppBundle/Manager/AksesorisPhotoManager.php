<?php

namespace AppBundle\Manager;

use AppBundle\Entity\AksesorisPhoto;
use AppBundle\Repository\AksesorisPhotoRepository;
use Doctrine\ORM\EntityManager;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\DiExtraBundle\Annotation\InjectParams;
use JMS\DiExtraBundle\Annotation\Service;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Service(id="manager.aksesorisPhoto")
 */
class AksesorisPhotoManager
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var AksesorisPhotoRepository
     */
    private $aksesorisPhotoRepository;

    /**
     * @InjectParams({
     *      "entityManager" = @Inject("doctrine.orm.default_entity_manager")
     * })
     */
    function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

        $this->aksesorisPhotoRepository = $this->entityManager->getRepository("AppBundle:AksesorisPhoto");
    }

    public function assignRequest(AksesorisPhoto $aksesorisPhoto, Request $request)
    {
        if (!is_null($request->files->get('file'))) {
            $aksesorisPhoto->setFile($request->files->get('file'));
        }
    }

    public function findAll()
    {
        $query = $this->aksesorisPhotoRepository->query()->getQuery();

        return $query->getResult();
    }

    public function findAllByAksesorisId($aksesorisId)
    {
        $query = $this->aksesorisPhotoRepository->queryByAksesorisId($aksesorisId)->getQuery();

        return $query->getResult();
    }

    public function findOneById($id)
    {
        $query = $this->aksesorisPhotoRepository->queryById($id)->getQuery();

        return $query->getOneOrNullResult();
    }

    public function remove(AksesorisPhoto $aksesorisPhoto)
    {
        $this->entityManager->remove($aksesorisPhoto);
        $this->entityManager->flush();
    }

    public function save(AksesorisPhoto $aksesorisPhoto)
    {
        $this->entityManager->persist($aksesorisPhoto);
        $this->entityManager->flush();
    }
}
