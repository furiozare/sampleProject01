<?php

namespace AppBundle\Manager;

use AppBundle\Entity\EmailSubscribe;
use AppBundle\Repository\EmailSubscribeRepository;
use Doctrine\ORM\EntityManager;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\DiExtraBundle\Annotation\InjectParams;
use JMS\DiExtraBundle\Annotation\Service;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Service(id="manager.emailSubscribe")
 */
class EmailSubscribeManager
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var EmailSubscribeRepository
     */
    private $emailSubscribeRepository;

    /**
     * @InjectParams({
     *      "entityManager" = @Inject("doctrine.orm.default_entity_manager")
     * })
     */
    function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

        $this->emailSubscribeRepository = $this->entityManager->getRepository("AppBundle:EmailSubscribe");
    }

    public function assignRequest(EmailSubscribe $emailSubscribe, Request $request)
    {
        if (!is_null($request->request->get('email'))) {
            $email = trim($request->request->get('email'));
            if ($email != "") {
                $emailSubscribe->setEmail($email);
            } else {
                $emailSubscribe->setEmail(null);
            }
        }
        if (is_null($request->request->get('aktif'))) {
            $emailSubscribe->setAktif(false);
        } else {
            $emailSubscribe->setAktif(true);
        }
    }

    public function findAllAktif()
    {
        $query = $this->emailSubscribeRepository->queryAktif()->getQuery();

        return $query->getResult();
    }

    public function findAllAktifNotYetBlastedByArtikelId($artikelId)
    {
        $query = $this->emailSubscribeRepository->queryAktif();
        $query = $this->emailSubscribeRepository->queryNotYetBlastedByArtikelId($artikelId, $query);

        return $query->getQuery()->getResult();
    }

    public function findAll()
    {
        $query = $this->emailSubscribeRepository->query()->getQuery();

        return $query->getResult();
    }

    public function findOneById($id)
    {
        $query = $this->emailSubscribeRepository->queryById($id)->getQuery();

        return $query->getOneOrNullResult();
    }

    public function remove(EmailSubscribe $emailSubscribe)
    {
        $this->entityManager->remove($emailSubscribe);
        $this->entityManager->flush();
    }

    public function save(EmailSubscribe $emailSubscribe)
    {
        if (!$emailSubscribe->getId()) {
            $this->entityManager->persist($emailSubscribe);
        }
        $this->entityManager->flush();
    }
}
