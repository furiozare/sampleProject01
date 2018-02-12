<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Dealer;
use AppBundle\Entity\Kota;
use AppBundle\Repository\DealerRepository;
use AppBundle\Repository\KotaRepository;
use Doctrine\ORM\EntityManager;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\DiExtraBundle\Annotation\InjectParams;
use JMS\DiExtraBundle\Annotation\Service;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Service(id="manager.dealer")
 */
class DealerManager
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var DealerRepository
     */
    private $dealerRepository;

    /**
     * @var KotaRepository
     */
    private $kotaRepository;

    /**
     * @InjectParams({
     *      "entityManager" = @Inject("doctrine.orm.default_entity_manager")
     * })
     */
    function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

        $this->dealerRepository = $this->entityManager->getRepository("AppBundle:Dealer");
        $this->kotaRepository   = $this->entityManager->getRepository("AppBundle:Kota");
    }

    public function assignRequest(Dealer $dealer, Request $request)
    {
        if (!is_null($request->request->get('nama'))) {
            $dealer->setNama($request->request->get('nama'));
        }
        if (!is_null($request->request->get('telepon'))) {
            $dealer->setTelepon($request->request->get('telepon'));
        }
        if (!is_null($request->request->get('email'))) {
            $dealer->setEmail($request->request->get('email'));
        }
        if (!is_null($request->request->get('email_sales'))) {
            $dealer->setEmailSales($request->request->get('email_sales'));
        }
        if (!is_null($request->request->get('email_service'))) {
            $dealer->setEmailService($request->request->get('email_service'));
        }
        if (!is_null($request->request->get('fax'))) {
            $dealer->setFax($request->request->get('fax'));
        }
        if (!is_null($request->request->get('alamat'))) {
            $dealer->setAlamat($request->request->get('alamat'));
        }
        if (!is_null($request->request->get('longitude'))) {
            $dealer->setLongitude($request->request->get('longitude'));
        }
        if (!is_null($request->request->get('latitude'))) {
            $dealer->setLatitude($request->request->get('latitude'));
        }
        if (!is_null($request->request->get('zoomPoint'))) {
            $dealer->setZoomPoint($request->request->get('zoomPoint'));
        }
        if (is_null($request->request->get('aktif'))) {
            $dealer->setAktif(false);
        } else {
            $dealer->setAktif(true);
        }
        if (!is_null($request->request->get('kota'))) {
            $kota = $this->kotaRepository->queryById($request->request->get('kota'))->getQuery()->getOneOrNullResult();
            if ($kota instanceof Kota) {
                $dealer->setKota($kota);
            }
        }
    }

    public function findAllAktif()
    {
        $query = $this->dealerRepository->queryAktif();
        $query = $this->dealerRepository->queryOrderByKotaAndNamaASC($query)->getQuery();

        return $query->getResult();
    }

    public function findAll()
    {
        $query = $this->dealerRepository->queryOrderByKotaAndNamaASC()->getQuery();

        return $query->getResult();
    }

    public function findOneById($id)
    {
        $query = $this->dealerRepository->queryById($id)->getQuery();

        return $query->getOneOrNullResult();
    }

    public function remove(Dealer $dealer)
    {
        $this->entityManager->remove($dealer);
        $this->entityManager->flush();
    }

    public function save(Dealer $dealer)
    {
        $this->entityManager->persist($dealer);
        $this->entityManager->flush();
    }
}
