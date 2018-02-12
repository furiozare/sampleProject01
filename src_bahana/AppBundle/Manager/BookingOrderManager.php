<?php

namespace AppBundle\Manager;

use AppBundle\Entity\BookingOrder;
use AppBundle\Entity\Dealer;
use AppBundle\Entity\HargaOTR;
use AppBundle\Entity\Kendaraan;
use AppBundle\Repository\BookingOrderRepository;
use AppBundle\Repository\DealerRepository;
use AppBundle\Repository\HargaOTRRepository;
use AppBundle\Repository\KendaraanRepository;
use Doctrine\ORM\EntityManager;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\DiExtraBundle\Annotation\InjectParams;
use JMS\DiExtraBundle\Annotation\Service;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Service(id="manager.bookingOrder")
 */
class BookingOrderManager
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var BookingOrderRepository
     */
    private $bookingOrderRepository;

    /**
     * @var DealerRepository
     */
    private $dealerRepository;

    /**
     * @var KendaraanRepository
     */
    private $kendaraanRepository;

    /**
     * @var HargaOTRRepository
     */
    private $hargaOTRRepository;

    /**
     * @InjectParams({
     *      "entityManager" = @Inject("doctrine.orm.default_entity_manager")
     * })
     */
    function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

        $this->bookingOrderRepository = $this->entityManager->getRepository("AppBundle:BookingOrder");
        $this->dealerRepository       = $this->entityManager->getRepository("AppBundle:Dealer");
        $this->kendaraanRepository    = $this->entityManager->getRepository("AppBundle:Kendaraan");
        $this->hargaOTRRepository     = $this->entityManager->getRepository("AppBundle:HargaOTR");
    }

    public function assignRequest(BookingOrder $bookingOrder, Request $request)
    {
        if (!is_null($request->request->get('namaLengkap'))) {
            $bookingOrder->setNamaLengkap($request->request->get('namaLengkap'));
        }
        if (!is_null($request->request->get('email'))) {
            $bookingOrder->setEmail($request->request->get('email'));
        }
        if (!is_null($request->request->get('telepon'))) {
            $bookingOrder->setTelepon($request->request->get('telepon'));
        }
        if (!is_null($request->request->get('jenisKelamin'))) {
            $bookingOrder->setJenisKelamin($request->request->get('jenisKelamin'));
        }
        if (!is_null($request->request->get('alamat'))) {
            $bookingOrder->setAlamat($request->request->get('alamat'));
        }
        if (!is_null($request->request->get('kota'))) {
            $bookingOrder->setKota($request->request->get('kota'));
        }
        if (!is_null($request->request->get('kodePos'))) {
            $bookingOrder->setKodePos($request->request->get('kodePos'));
        }
        if (!is_null($request->request->get('kelurahan'))) {
            $bookingOrder->setKelurahan($request->request->get('kelurahan'));
        }
        if (!is_null($request->request->get('kecamatan'))) {
            $bookingOrder->setKecamatan($request->request->get('kecamatan'));
        }
        if (!is_null($request->request->get('noKTP'))) {
            $bookingOrder->setNoKTP($request->request->get('noKTP'));
        }
        if (!is_null($request->request->get('noNPWP'))) {
            $bookingOrder->setNoNPWP($request->request->get('noNPWP'));
        }
        if (!is_null($request->request->get('tanggalLahir'))) {
            $bookingOrder->setTanggalLahir(\DateTime::createFromFormat('Y-m-d',
                $request->request->get('tanggalLahir')));
        }
        if (!is_null($request->request->get('tempatLahir'))) {
            $bookingOrder->setTempatLahir($request->request->get('tempatLahir'));
        }
        if (!is_null($request->request->get('dealer'))) {
            $dealer = $this->dealerRepository->queryById($request->request->get('dealer'))->getQuery()->getOneOrNullResult();
            if ($dealer instanceof Dealer) {
                $bookingOrder->setDealer($dealer);
            }
        }
        if (!is_null($request->request->get('hargaOTR'))) {
            $hargaOTR = $this->hargaOTRRepository->queryById($request->request->get('hargaOTR'))->getQuery()->getOneOrNullResult();
            if ($hargaOTR instanceof HargaOTR) {
                $bookingOrder->setHargaOTR($hargaOTR);
            }
        }
    }

    public function findAll()
    {
        $query = $this->bookingOrderRepository->query()->getQuery();

        return $query->getResult();
    }

    public function findAllByDateRangeAndKendaraan($startDate, $endDate, $kendaraan)
    {
        $query = $this->bookingOrderRepository->queryByDateRange($startDate, $endDate);

        $kendaraan = $this->kendaraanRepository->queryById($kendaraan)->getQuery()->getOneOrNullResult();
        if ($kendaraan instanceof Kendaraan) {
            $query = $this->bookingOrderRepository->queryByKendaraanId($kendaraan->getId(), $query);
        }

        $query = $query->getQuery();

        return $query->getResult();
    }

    public function findOneById($id)
    {
        $query = $this->bookingOrderRepository->queryById($id)->getQuery();

        return $query->getOneOrNullResult();
    }

    public function remove(BookingOrder $bookingOrder)
    {
        $this->entityManager->remove($bookingOrder);
        $this->entityManager->flush();
    }

    public function save(BookingOrder $bookingOrder)
    {
        $this->entityManager->persist($bookingOrder);
        $this->entityManager->flush();
    }
}
