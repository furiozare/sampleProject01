<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Kontak;
use AppBundle\Repository\KontakRepository;
use Doctrine\ORM\EntityManager;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\DiExtraBundle\Annotation\InjectParams;
use JMS\DiExtraBundle\Annotation\Service;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Service(id="manager.kontak")
 */
class KontakManager
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var KontakRepository
     */
    private $kontakRepository;

    /**
     * @InjectParams({
     *      "entityManager" = @Inject("doctrine.orm.default_entity_manager")
     * })
     */
    function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

        $this->kontakRepository = $this->entityManager->getRepository("AppBundle:Kontak");
    }

    public function assignRequest(Kontak $kontak, Request $request)
    {
        if (!is_null($request->request->get('namaLengkap')) && $request->request->get('namaLengkap') != '') {
            $kontak->setNamaLengkap($request->request->get('namaLengkap'));
        }
        if (!is_null($request->request->get('email')) && $request->request->get('email') != '') {
            $kontak->setEmail($request->request->get('email'));
        }
        if (!is_null($request->request->get('subyek')) && $request->request->get('subyek') != '') {
            $kontak->setSubyek($request->request->get('subyek'));
        }
        if (!is_null($request->request->get('pesan')) && $request->request->get('pesan') != '') {
            $kontak->setPesan($request->request->get('pesan'));
        }
    }

    public function findAll()
    {
        $query = $this->kontakRepository->query();
        $query = $this->kontakRepository->queryOrderByCreatedAtDESC($query)->getQuery();

        return $query->getResult();
    }

    public function findOneById($id)
    {
        $query = $this->kontakRepository->queryById($id)->getQuery();

        return $query->getOneOrNullResult();
    }

    public function remove(Kontak $kontak)
    {
        $this->entityManager->remove($kontak);
        $this->entityManager->flush();
    }

    public function save(Kontak $kontak)
    {
        $this->entityManager->persist($kontak);
        $this->entityManager->flush();
    }
}
