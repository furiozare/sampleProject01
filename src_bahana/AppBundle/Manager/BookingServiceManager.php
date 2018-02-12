<?php

namespace AppBundle\Manager;

use AppBundle\Entity\BookingService;
use AppBundle\Entity\Dealer;
use AppBundle\Entity\Kendaraan;
use AppBundle\Repository\BookingServiceRepository;
use AppBundle\Repository\DealerRepository;
use AppBundle\Repository\KendaraanRepository;
use Doctrine\ORM\EntityManager;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\DiExtraBundle\Annotation\InjectParams;
use JMS\DiExtraBundle\Annotation\Service;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Service(id="manager.bookingService")
 */
class BookingServiceManager
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var BookingServiceRepository
     */
    private $bookingServiceRepository;

    /**
     * @var KendaraanRepository
     */
    private $kendaraanRepository;

    /**
     * @var DealerRepository
     */
    private $dealerRepository;

    /**
     * @InjectParams({
     *      "entityManager" = @Inject("doctrine.orm.default_entity_manager")
     * })
     */
    function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

        $this->bookingServiceRepository = $this->entityManager->getRepository("AppBundle:BookingService");
        $this->kendaraanRepository      = $this->entityManager->getRepository("AppBundle:Kendaraan");
        $this->dealerRepository         = $this->entityManager->getRepository("AppBundle:Dealer");
    }

    public function assignRequest(BookingService $bookingService, Request $request)
    {
        if (!is_null($request->request->get('nama')) && $request->request->get('nama') != '') {
            $bookingService->setNama($request->request->get('nama'));
        }
        if (!is_null($request->request->get('email')) && $request->request->get('email') != '') {
            $bookingService->setEmail($request->request->get('email'));
        }
        if (!is_null($request->request->get('noPolisi')) && $request->request->get('noPolisi') != '') {
            $bookingService->setNoPolisi($request->request->get('noPolisi'));
        }
        if (!is_null($request->request->get('telepon')) && $request->request->get('telepon') != '') {
            $bookingService->setTelepon($request->request->get('telepon'));
        }
        if (!is_null($request->request->get('tanggalWaktu')) && $request->request->get('tanggalWaktu') != '') {
            $bookingService->setTanggalWaktu(\DateTime::createFromFormat('Y-m-d H:i:s',
                $request->request->get('tanggalWaktu')));
        }
        if (!is_null($request->request->get('dealer')) && $request->request->get('dealer') != '') {
            $dealer = $this->dealerRepository->queryById($request->request->get('dealer'))->getQuery()->getOneOrNullResult();
            if ($dealer instanceof Dealer) {
                $bookingService->setDealer($dealer);
            }
        }
    }

    public function findAll()
    {
        $query = $this->bookingServiceRepository->query()->getQuery();

        return $query->getResult();
    }

    public function findAllByDateRangeAndDealer($startDate, $endDate, $dealer)
    {
        $query = $this->bookingServiceRepository->queryByDateRange($startDate, $endDate);

        $dealer = $this->dealerRepository->queryById($dealer)->getQuery()->getOneOrNullResult();
        if ($dealer instanceof Dealer) {
            $query = $this->bookingServiceRepository->queryByDealerId($dealer->getId(), $query);
        }

        $query = $query->getQuery();

        return $query->getResult();
    }

    public function findOneById($id)
    {
        $query = $this->bookingServiceRepository->queryById($id)->getQuery();

        return $query->getOneOrNullResult();
    }

    public function remove(BookingService $bookingService)
    {
        $this->entityManager->remove($bookingService);
        $this->entityManager->flush();
    }

    public function save(BookingService $bookingService)
    {
        $this->entityManager->persist($bookingService);
        $this->entityManager->flush();
    }
}
