<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Headline;
use AppBundle\Repository\HeadlineRepository;
use Doctrine\ORM\EntityManager;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\DiExtraBundle\Annotation\InjectParams;
use JMS\DiExtraBundle\Annotation\Service;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Service(id="manager.headline")
 */
class HeadlineManager
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var HeadlineRepository
     */
    private $headlineRepository;

    /**
     * @InjectParams({
     *      "entityManager" = @Inject("doctrine.orm.default_entity_manager")
     * })
     */
    function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

        $this->headlineRepository = $this->entityManager->getRepository("AppBundle:Headline");
    }

    public function assignRequest(Headline $headline, Request $request)
    {
        if (!is_null($request->files->get('file'))) {
            $headline->setFile($request->files->get('file'));
        }
        if (!is_null($request->request->get('nama')) && trim($request->request->get('nama')) != '') {
            $headline->setNama($request->request->get('nama'));
        }
        if (!is_null($request->request->get('seed')) && trim($request->request->get('seed')) != '') {
            $headline->setSeed($request->request->get('seed'));
        }
        if (is_null($request->request->get('aktif'))) {
            $headline->setAktif(false);
        } else {
            $headline->setAktif(true);
        }
    }

    public function findAllAktif()
    {
        $query = $this->headlineRepository->queryAktif();
        $query = $this->headlineRepository->queryOrderBySeed($query)->getQuery();

        return $query->getResult();
    }

    public function findAll()
    {
        $query = $this->headlineRepository->query();
        $query = $this->headlineRepository->queryOrderBySeed($query)->getQuery();

        return $query->getResult();
    }

    public function findOneById($id)
    {
        $query = $this->headlineRepository->queryById($id)->getQuery();

        return $query->getOneOrNullResult();
    }

    public function remove(Headline $headline)
    {
        $this->entityManager->remove($headline);
        $this->entityManager->flush();
    }

    public function save(Headline $headline)
    {
        $this->entityManager->persist($headline);
        $this->entityManager->flush();
    }
}
