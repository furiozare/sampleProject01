<?php

namespace AppBundle\Manager;

use AppBundle\Entity\PartPhoto;
use AppBundle\Repository\PartPhotoRepository;
use Doctrine\ORM\EntityManager;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\DiExtraBundle\Annotation\InjectParams;
use JMS\DiExtraBundle\Annotation\Service;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Service(id="manager.partPhoto")
 */
class PartPhotoManager
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var PartPhotoRepository
     */
    private $partPhotoRepository;

    /**
     * @InjectParams({
     *      "entityManager" = @Inject("doctrine.orm.default_entity_manager")
     * })
     */
    function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

        $this->partPhotoRepository = $this->entityManager->getRepository("AppBundle:PartPhoto");
    }

    public function assignRequest(PartPhoto $partPhoto, Request $request)
    {
        if (!is_null($request->files->get('file'))) {
            $partPhoto->setFile($request->files->get('file'));
        }
    }

    public function findAll()
    {
        $query = $this->partPhotoRepository->query()->getQuery();

        return $query->getResult();
    }

    public function findAllByPartId($partId)
    {
        $query = $this->partPhotoRepository->queryByPartId($partId)->getQuery();

        return $query->getResult();
    }

    public function findOneById($id)
    {
        $query = $this->partPhotoRepository->queryById($id)->getQuery();

        return $query->getOneOrNullResult();
    }

    public function remove(PartPhoto $partPhoto)
    {
        $this->entityManager->remove($partPhoto);
        $this->entityManager->flush();
    }

    public function save(PartPhoto $partPhoto)
    {
        $this->entityManager->persist($partPhoto);
        $this->entityManager->flush();
    }
}
