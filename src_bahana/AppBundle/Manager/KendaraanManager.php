<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Kategori;
use AppBundle\Entity\Kendaraan;
use AppBundle\Repository\KategoriRepository;
use AppBundle\Repository\KendaraanRepository;
use Doctrine\ORM\EntityManager;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\DiExtraBundle\Annotation\InjectParams;
use JMS\DiExtraBundle\Annotation\Service;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Service(id="manager.kendaraan")
 */
class KendaraanManager
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var KendaraanRepository
     */
    private $kendaraanRepository;

    /**
     * @var KategoriRepository
     */
    private $kategoriRepository;

    /**
     * @InjectParams({
     *      "entityManager" = @Inject("doctrine.orm.default_entity_manager")
     * })
     */
    function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

        $this->kendaraanRepository = $this->entityManager->getRepository("AppBundle:Kendaraan");
        $this->kategoriRepository  = $this->entityManager->getRepository("AppBundle:Kategori");
    }

    public function assignRequest(Kendaraan $kendaraan, Request $request)
    {
        if (!is_null($request->request->get('nama'))) {
            if ($request->request->get('nama') != '') {
                $kendaraan->setNama($request->request->get('nama'));
            } else {
                $kendaraan->setNama(null);
            }
        }
        if (!is_null($request->request->get('kode'))) {
            if ($request->request->get('kode') != '') {
                $kendaraan->setKode($request->request->get('kode'));
            } else {
                $kendaraan->setKode(null);
            }
        }
        if (!is_null($request->request->get('harga'))) {
            if ($request->request->get('harga') != '') {
                $kendaraan->setHarga($request->request->get('harga'));
            } else {
                $kendaraan->setHarga(null);
            }
        }
        if (!is_null($request->request->get('tagLine'))) {
            if ($request->request->get('tagLine') != '') {
                $kendaraan->setTagLine($request->request->get('tagLine'));
            } else {
                $kendaraan->setTagLine(null);
            }
        }
        if (!is_null($request->request->get('description'))) {
            $kendaraan->setDescription($request->request->get('description'));
        }
        if (is_null($request->request->get('aktif'))) {
            $kendaraan->setAktif(false);
        } else {
            $kendaraan->setAktif(true);
        }
        if (!is_null($request->request->get('kategori'))) {
            $kategori = $this->kategoriRepository->queryById($request->request->get('kategori'))->getQuery()->getOneOrNullResult();
            if ($kategori instanceof Kategori) {
                $kendaraan->setKategori($kategori);
            } else {
                $kendaraan->setKategori();
            }
        }
    }

    public function assignRequestSpecification(Kendaraan $kendaraan, Request $request)
    {
        if (!is_null($request->request->get('pxlxt'))) {
            if ($request->request->get('pxlxt') != '') {
                $kendaraan->setPxlxt($request->request->get('pxlxt'));
            } else {
                $kendaraan->setPxlxt(null);
            }
        }
        if (!is_null($request->request->get('wheelBase'))) {
            if ($request->request->get('wheelBase') != '') {
                $kendaraan->setWheelBase($request->request->get('wheelBase'));
            } else {
                $kendaraan->setWheelBase(null);
            }
        }
        if (!is_null($request->request->get('seatHeight'))) {
            if ($request->request->get('seatHeight') != '') {
                $kendaraan->setSeatHeight($request->request->get('seatHeight'));
            } else {
                $kendaraan->setSeatHeight(null);
            }
        }
        if (!is_null($request->request->get('weight'))) {
            if ($request->request->get('weight') != '') {
                $kendaraan->setWeight($request->request->get('weight'));
            } else {
                $kendaraan->setWeight(null);
            }
        }
        if (!is_null($request->request->get('fuelCap'))) {
            if ($request->request->get('fuelCap') != '') {
                $kendaraan->setFuelCap($request->request->get('fuelCap'));
            } else {
                $kendaraan->setFuelCap(null);
            }
        }
        if (!is_null($request->request->get('chasisType'))) {
            if ($request->request->get('chasisType') != '') {
                $kendaraan->setChasisType($request->request->get('chasisType'));
            } else {
                $kendaraan->setChasisType(null);
            }
        }
        if (!is_null($request->request->get('frontSuspension'))) {
            if ($request->request->get('frontSuspension') != '') {
                $kendaraan->setFrontSuspension($request->request->get('frontSuspension'));
            } else {
                $kendaraan->setFrontSuspension(null);
            }
        }
        if (!is_null($request->request->get('rearSuspension'))) {
            if ($request->request->get('rearSuspension') != '') {
                $kendaraan->setRearSuspension($request->request->get('rearSuspension'));
            } else {
                $kendaraan->setRearSuspension(null);
            }
        }
        if (!is_null($request->request->get('frontBrake'))) {
            if ($request->request->get('frontBrake') != '') {
                $kendaraan->setFrontBrake($request->request->get('frontBrake'));
            } else {
                $kendaraan->setFrontBrake(null);
            }
        }
        if (!is_null($request->request->get('rearBrake'))) {
            if ($request->request->get('rearBrake') != '') {
                $kendaraan->setRearBrake($request->request->get('rearBrake'));
            } else {
                $kendaraan->setRearBrake(null);
            }
        }
        if (!is_null($request->request->get('frontWheel'))) {
            if ($request->request->get('frontWheel') != '') {
                $kendaraan->setFrontWheel($request->request->get('frontWheel'));
            } else {
                $kendaraan->setFrontWheel(null);
            }
        }
        if (!is_null($request->request->get('rearWheel'))) {
            if ($request->request->get('rearWheel') != '') {
                $kendaraan->setRearWheel($request->request->get('rearWheel'));
            } else {
                $kendaraan->setRearWheel(null);
            }
        }
        if (!is_null($request->request->get('engine'))) {
            if ($request->request->get('engine') != '') {
                $kendaraan->setEngine($request->request->get('engine'));
            } else {
                $kendaraan->setEngine(null);
            }
        }
        if (!is_null($request->request->get('cylinder'))) {
            if ($request->request->get('cylinder') != '') {
                $kendaraan->setCylinder($request->request->get('cylinder'));
            } else {
                $kendaraan->setCylinder(null);
            }
        }
        if (!is_null($request->request->get('cylinderVolume'))) {
            if ($request->request->get('cylinderVolume') != '') {
                $kendaraan->setCylinderVolume($request->request->get('cylinderVolume'));
            } else {
                $kendaraan->setCylinderVolume(null);
            }
        }
        if (!is_null($request->request->get('boreXStroke'))) {
            if ($request->request->get('boreXStroke') != '') {
                $kendaraan->setBoreXStroke($request->request->get('boreXStroke'));
            } else {
                $kendaraan->setBoreXStroke(null);
            }
        }
        if (!is_null($request->request->get('compressionRatio'))) {
            if ($request->request->get('compressionRatio') != '') {
                $kendaraan->setCompressionRatio($request->request->get('compressionRatio'));
            } else {
                $kendaraan->setCompressionRatio(null);
            }
        }
        if (!is_null($request->request->get('horsePower'))) {
            if ($request->request->get('horsePower') != '') {
                $kendaraan->setHorsePower($request->request->get('horsePower'));
            } else {
                $kendaraan->setHorsePower(null);
            }
        }
        if (!is_null($request->request->get('torque'))) {
            if ($request->request->get('torque') != '') {
                $kendaraan->setTorque($request->request->get('torque'));
            } else {
                $kendaraan->setTorque(null);
            }
        }
        if (!is_null($request->request->get('systemStarter'))) {
            if ($request->request->get('systemStarter') != '') {
                $kendaraan->setSystemStarter($request->request->get('systemStarter'));
            } else {
                $kendaraan->setSystemStarter(null);
            }
        }
        if (!is_null($request->request->get('systemOil'))) {
            if ($request->request->get('systemOil') != '') {
                $kendaraan->setSystemOil($request->request->get('systemOil'));
            } else {
                $kendaraan->setSystemOil(null);
            }
        }
        if (!is_null($request->request->get('engineOilCap'))) {
            if ($request->request->get('engineOilCap') != '') {
                $kendaraan->setEngineOilCap($request->request->get('engineOilCap'));
            } else {
                $kendaraan->setEngineOilCap(null);
            }
        }
        if (!is_null($request->request->get('fuelSystem'))) {
            if ($request->request->get('fuelSystem') != '') {
                $kendaraan->setFuelSystem($request->request->get('fuelSystem'));
            } else {
                $kendaraan->setFuelSystem(null);
            }
        }
        if (!is_null($request->request->get('clutch'))) {
            if ($request->request->get('clutch') != '') {
                $kendaraan->setClutch($request->request->get('clutch'));
            } else {
                $kendaraan->setClutch(null);
            }
        }
        if (!is_null($request->request->get('transmission'))) {
            if ($request->request->get('transmission') != '') {
                $kendaraan->setTransmission($request->request->get('transmission'));
            } else {
                $kendaraan->setTransmission(null);
            }
        }
        if (!is_null($request->request->get('electricity'))) {
            if ($request->request->get('electricity') != '') {
                $kendaraan->setElectricity($request->request->get('electricity'));
            } else {
                $kendaraan->setElectricity(null);
            }
        }
        if (!is_null($request->request->get('ignitionSystem'))) {
            if ($request->request->get('ignitionSystem') != '') {
                $kendaraan->setIgnitionSystem($request->request->get('ignitionSystem'));
            } else {
                $kendaraan->setIgnitionSystem(null);
            }
        }
        if (!is_null($request->request->get('battery'))) {
            if ($request->request->get('battery') != '') {
                $kendaraan->setBattery($request->request->get('battery'));
            } else {
                $kendaraan->setBattery(null);
            }
        }
        if (!is_null($request->request->get('sparkPlug'))) {
            if ($request->request->get('sparkPlug') != '') {
                $kendaraan->setSparkPlug($request->request->get('sparkPlug'));
            } else {
                $kendaraan->setSparkPlug(null);
            }
        }
    }

    public function findAllAktif()
    {
        $query = $this->kendaraanRepository->queryAktif();
        $query = $this->kendaraanRepository->queryOrderByKategoriAndNamaASC($query)->getQuery();

        return $query->getResult();
    }

    public function findAllAktifByKategoriId($kategoriId)
    {
        $query = $this->kendaraanRepository
            ->queryAktif(
                $this->kendaraanRepository->queryByKategoriId($kategoriId)
            )
            ->getQuery();

        return $query->getResult();
    }

    public function findAll()
    {
        $query = $this->kendaraanRepository->queryOrderByKategoriAndNamaASC()->getQuery();

        return $query->getResult();
    }

    public function findOneById($id)
    {
        $query = $this->kendaraanRepository->queryById($id)->getQuery();

        return $query->getOneOrNullResult();
    }

    public function remove(Kendaraan $kendaraan)
    {
        $this->entityManager->remove($kendaraan);
        $this->entityManager->flush();
    }

    public function save(Kendaraan $kendaraan)
    {
        $this->entityManager->persist($kendaraan);
        $this->entityManager->flush();
    }
}
