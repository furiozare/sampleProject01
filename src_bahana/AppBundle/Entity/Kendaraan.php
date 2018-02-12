<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Blameable;
use Gedmo\Mapping\Annotation\Slug;
use Gedmo\Mapping\Annotation\Timestampable;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\MaxDepth;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

/**
 * Kendaraan
 *
 * @ORM\Table(name="kendaraan")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\KendaraanRepository")
 * @UniqueEntity(fields={"kode"})
 */
class Kendaraan
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @Groups(groups={"kendaraan", "dropdown", "service", "kendaraanWarna", "kendaraanDetail", "hargaOTR", "bookingOrder"})
     */
    private $id;

    /**
     * @ORM\Column(name="nama", type="string", length=255, nullable=false)
     *
     * @NotBlank()
     *
     * @Groups(groups={"kendaraan", "dropdown", "service", "kendaraanWarna", "kendaraanDetail", "hargaOTR", "bookingOrder"})
     */
    private $nama;

    /**
     * @ORM\Column(name="slug", type="string", length=255, unique=true, nullable=true)
     *
     * @Slug(fields={"nama"})
     */
    private $slug;

    /**
     * @ORM\Column(name="kode", type="string", length=50, unique=true, nullable=false)
     *
     * @NotBlank()
     *
     * @Groups(groups={"kendaraan", "service"})
     */
    private $kode;

    /**
     * @ORM\Column(name="harga", type="decimal", nullable=false)
     *
     * @NotBlank()
     * @Type(type="numeric")
     * @GreaterThanOrEqual(value=0)
     *
     * @Groups(groups={"kendaraan"})
     */
    private $harga = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="tag_line", type="text", length=65535, nullable=true)
     *
     * @Groups(groups={"kendaraan"})
     */
    private $tagLine;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     *
     * @Groups(groups={"kendaraan"})
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="pxlxt", type="string", length=100, nullable=true)
     *
     * @Groups(groups={"kendaraan"})
     */
    private $pxlxt;

    /**
     * @var string
     *
     * @ORM\Column(name="wheel_base", type="string", length=100, nullable=true)
     *
     * @Groups(groups={"kendaraan"})
     */
    private $wheelBase;

    /**
     * @var string
     *
     * @ORM\Column(name="seat_height", type="string", length=100, nullable=true)
     *
     * @Groups(groups={"kendaraan"})
     */
    private $seatHeight;

    /**
     * @var string
     *
     * @ORM\Column(name="weight", type="string", length=100, nullable=true)
     *
     * @Groups(groups={"kendaraan"})
     */
    private $weight;

    /**
     * @var string
     *
     * @ORM\Column(name="fuel_cap", type="string", length=100, nullable=true)
     *
     * @Groups(groups={"kendaraan"})
     */
    private $fuelCap;

    /**
     * @var string
     *
     * @ORM\Column(name="chasis_type", type="string", length=100, nullable=true)
     *
     * @Groups(groups={"kendaraan"})
     */
    private $chasisType;

    /**
     * @var string
     *
     * @ORM\Column(name="front_suspension", type="string", length=100, nullable=true)
     *
     * @Groups(groups={"kendaraan"})
     */
    private $frontSuspension;

    /**
     * @var string
     *
     * @ORM\Column(name="rear_suspension", type="string", length=100, nullable=true)
     *
     * @Groups(groups={"kendaraan"})
     */
    private $rearSuspension;

    /**
     * @var string
     *
     * @ORM\Column(name="front_brake", type="string", length=100, nullable=true)
     *
     * @Groups(groups={"kendaraan"})
     */
    private $frontBrake;

    /**
     * @var string
     *
     * @ORM\Column(name="rear_brake", type="string", length=100, nullable=true)
     *
     * @Groups(groups={"kendaraan"})
     */
    private $rearBrake;

    /**
     * @var string
     *
     * @ORM\Column(name="front_wheel", type="string", length=100, nullable=true)
     *
     * @Groups(groups={"kendaraan"})
     */
    private $frontWheel;

    /**
     * @var string
     *
     * @ORM\Column(name="rear_wheel", type="string", length=100, nullable=true)
     *
     * @Groups(groups={"kendaraan"})
     */
    private $rearWheel;

    /**
     * @var string
     *
     * @ORM\Column(name="engine", type="string", length=100, nullable=true)
     *
     * @Groups(groups={"kendaraan"})
     */
    private $engine;

    /**
     * @var string
     *
     * @ORM\Column(name="cylinder", type="string", length=100, nullable=true)
     *
     * @Groups(groups={"kendaraan"})
     */
    private $cylinder;

    /**
     * @var string
     *
     * @ORM\Column(name="cylinder_volume", type="string", length=100, nullable=true)
     *
     * @Groups(groups={"kendaraan"})
     */
    private $cylinderVolume;

    /**
     * @var string
     *
     * @ORM\Column(name="bore_x_stroke", type="string", length=100, nullable=true)
     *
     * @Groups(groups={"kendaraan"})
     */
    private $boreXStroke;

    /**
     * @var string
     *
     * @ORM\Column(name="compression_ratio", type="string", length=100, nullable=true)
     *
     * @Groups(groups={"kendaraan"})
     */
    private $compressionRatio;

    /**
     * @var string
     *
     * @ORM\Column(name="horse_power", type="string", length=100, nullable=true)
     *
     * @Groups(groups={"kendaraan"})
     */
    private $horsePower;

    /**
     * @var string
     *
     * @ORM\Column(name="torque", type="string", length=100, nullable=true)
     *
     * @Groups(groups={"kendaraan"})
     */
    private $torque;

    /**
     * @var string
     *
     * @ORM\Column(name="system_starter", type="string", length=100, nullable=true)
     *
     * @Groups(groups={"kendaraan"})
     */
    private $systemStarter;

    /**
     * @var string
     *
     * @ORM\Column(name="system_oil", type="string", length=100, nullable=true)
     *
     * @Groups(groups={"kendaraan"})
     */
    private $systemOil;

    /**
     * @var string
     *
     * @ORM\Column(name="engine_oil_cap", type="string", length=100, nullable=true)
     *
     * @Groups(groups={"kendaraan"})
     */
    private $engineOilCap;

    /**
     * @var string
     *
     * @ORM\Column(name="fuel_system", type="string", length=100, nullable=true)
     *
     * @Groups(groups={"kendaraan"})
     */
    private $fuelSystem;

    /**
     * @var string
     *
     * @ORM\Column(name="clutch", type="string", length=100, nullable=true)
     *
     * @Groups(groups={"kendaraan"})
     */
    private $clutch;

    /**
     * @var string
     *
     * @ORM\Column(name="transmission", type="string", length=100, nullable=true)
     *
     * @Groups(groups={"kendaraan"})
     */
    private $transmission;

    /**
     * @var string
     *
     * @ORM\Column(name="electricity", type="string", length=100, nullable=true)
     *
     * @Groups(groups={"kendaraan"})
     */
    private $electricity;

    /**
     * @var string
     *
     * @ORM\Column(name="ignition_system", type="string", length=100, nullable=true)
     *
     * @Groups(groups={"kendaraan"})
     */
    private $ignitionSystem;

    /**
     * @var string
     *
     * @ORM\Column(name="battery", type="string", length=100, nullable=true)
     *
     * @Groups(groups={"kendaraan"})
     */
    private $battery;

    /**
     * @var string
     *
     * @ORM\Column(name="spark_plug", type="string", length=100, nullable=true)
     *
     * @Groups(groups={"kendaraan"})
     */
    private $sparkPlug;

    /**
     * @var boolean
     *
     * @ORM\Column(name="aktif", type="boolean", nullable=false)
     *
     * @Groups(groups={"kendaraan"})
     */
    private $aktif = true;

    /**
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     * @Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @ORM\Column(name="edited_at", type="datetime", nullable=true)
     * @Timestampable(on="update")
     */
    private $editedAt;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="edited_by", referencedColumnName="id", nullable=true)
     * @Blameable(on="update")
     */
    private $editedBy;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id", nullable=true)
     * @Blameable(on="create")
     */
    private $createdBy;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Kategori", inversedBy="kendaraans")
     * @ORM\JoinColumn(name="kategori_id", referencedColumnName="id", nullable=false)
     *
     * @NotBlank()
     *
     * @Groups(groups={"kendaraan", "dropdown", "bookingOrder"})
     * @MaxDepth(depth=2)
     */
    private $kategori;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\KendaraanWarna", mappedBy="kendaraan")
     */
    private $kendaraanWarnas;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\KendaraanPhoto", mappedBy="kendaraan")
     */
    private $kendaraanPhotos;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Aksesoris", mappedBy="kendaraan")
     */
    private $aksesorises;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->kendaraanWarnas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->kendaraanPhotos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->aksesorises     = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nama
     *
     * @param string $nama
     *
     * @return Kendaraan
     */
    public function setNama($nama)
    {
        $this->nama = $nama;

        return $this;
    }

    /**
     * Get nama
     *
     * @return string
     */
    public function getNama()
    {
        return $this->nama;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Kendaraan
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set kode
     *
     * @param string $kode
     *
     * @return Kendaraan
     */
    public function setKode($kode)
    {
        $this->kode = $kode;

        return $this;
    }

    /**
     * Get kode
     *
     * @return string
     */
    public function getKode()
    {
        return $this->kode;
    }

    /**
     * Set harga
     *
     * @param string $harga
     *
     * @return Kendaraan
     */
    public function setHarga($harga)
    {
        $this->harga = $harga;

        return $this;
    }

    /**
     * Get harga
     *
     * @return string
     */
    public function getHarga()
    {
        return $this->harga;
    }

    /**
     * Set tagLine
     *
     * @param string $tagLine
     *
     * @return Kendaraan
     */
    public function setTagLine($tagLine)
    {
        $this->tagLine = $tagLine;

        return $this;
    }

    /**
     * Get tagLine
     *
     * @return string
     */
    public function getTagLine()
    {
        return $this->tagLine;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Kendaraan
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set pxlxt
     *
     * @param string $pxlxt
     *
     * @return Kendaraan
     */
    public function setPxlxt($pxlxt)
    {
        $this->pxlxt = $pxlxt;

        return $this;
    }

    /**
     * Get pxlxt
     *
     * @return string
     */
    public function getPxlxt()
    {
        return $this->pxlxt;
    }

    /**
     * Set wheelBase
     *
     * @param string $wheelBase
     *
     * @return Kendaraan
     */
    public function setWheelBase($wheelBase)
    {
        $this->wheelBase = $wheelBase;

        return $this;
    }

    /**
     * Get wheelBase
     *
     * @return string
     */
    public function getWheelBase()
    {
        return $this->wheelBase;
    }

    /**
     * Set seatHeight
     *
     * @param string $seatHeight
     *
     * @return Kendaraan
     */
    public function setSeatHeight($seatHeight)
    {
        $this->seatHeight = $seatHeight;

        return $this;
    }

    /**
     * Get seatHeight
     *
     * @return string
     */
    public function getSeatHeight()
    {
        return $this->seatHeight;
    }

    /**
     * Set weight
     *
     * @param string $weight
     *
     * @return Kendaraan
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight
     *
     * @return string
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Set fuelCap
     *
     * @param string $fuelCap
     *
     * @return Kendaraan
     */
    public function setFuelCap($fuelCap)
    {
        $this->fuelCap = $fuelCap;

        return $this;
    }

    /**
     * Get fuelCap
     *
     * @return string
     */
    public function getFuelCap()
    {
        return $this->fuelCap;
    }

    /**
     * Set chasisType
     *
     * @param string $chasisType
     *
     * @return Kendaraan
     */
    public function setChasisType($chasisType)
    {
        $this->chasisType = $chasisType;

        return $this;
    }

    /**
     * Get chasisType
     *
     * @return string
     */
    public function getChasisType()
    {
        return $this->chasisType;
    }

    /**
     * Set frontSuspension
     *
     * @param string $frontSuspension
     *
     * @return Kendaraan
     */
    public function setFrontSuspension($frontSuspension)
    {
        $this->frontSuspension = $frontSuspension;

        return $this;
    }

    /**
     * Get frontSuspension
     *
     * @return string
     */
    public function getFrontSuspension()
    {
        return $this->frontSuspension;
    }

    /**
     * Set rearSuspension
     *
     * @param string $rearSuspension
     *
     * @return Kendaraan
     */
    public function setRearSuspension($rearSuspension)
    {
        $this->rearSuspension = $rearSuspension;

        return $this;
    }

    /**
     * Get rearSuspension
     *
     * @return string
     */
    public function getRearSuspension()
    {
        return $this->rearSuspension;
    }

    /**
     * Set frontBrake
     *
     * @param string $frontBrake
     *
     * @return Kendaraan
     */
    public function setFrontBrake($frontBrake)
    {
        $this->frontBrake = $frontBrake;

        return $this;
    }

    /**
     * Get frontBrake
     *
     * @return string
     */
    public function getFrontBrake()
    {
        return $this->frontBrake;
    }

    /**
     * Set rearBrake
     *
     * @param string $rearBrake
     *
     * @return Kendaraan
     */
    public function setRearBrake($rearBrake)
    {
        $this->rearBrake = $rearBrake;

        return $this;
    }

    /**
     * Get rearBrake
     *
     * @return string
     */
    public function getRearBrake()
    {
        return $this->rearBrake;
    }

    /**
     * Set frontWheel
     *
     * @param string $frontWheel
     *
     * @return Kendaraan
     */
    public function setFrontWheel($frontWheel)
    {
        $this->frontWheel = $frontWheel;

        return $this;
    }

    /**
     * Get frontWheel
     *
     * @return string
     */
    public function getFrontWheel()
    {
        return $this->frontWheel;
    }

    /**
     * Set rearWheel
     *
     * @param string $rearWheel
     *
     * @return Kendaraan
     */
    public function setRearWheel($rearWheel)
    {
        $this->rearWheel = $rearWheel;

        return $this;
    }

    /**
     * Get rearWheel
     *
     * @return string
     */
    public function getRearWheel()
    {
        return $this->rearWheel;
    }

    /**
     * Set engine
     *
     * @param string $engine
     *
     * @return Kendaraan
     */
    public function setEngine($engine)
    {
        $this->engine = $engine;

        return $this;
    }

    /**
     * Get engine
     *
     * @return string
     */
    public function getEngine()
    {
        return $this->engine;
    }

    /**
     * Set cylinder
     *
     * @param string $cylinder
     *
     * @return Kendaraan
     */
    public function setCylinder($cylinder)
    {
        $this->cylinder = $cylinder;

        return $this;
    }

    /**
     * Get cylinder
     *
     * @return string
     */
    public function getCylinder()
    {
        return $this->cylinder;
    }

    /**
     * Set cylinderVolume
     *
     * @param string $cylinderVolume
     *
     * @return Kendaraan
     */
    public function setCylinderVolume($cylinderVolume)
    {
        $this->cylinderVolume = $cylinderVolume;

        return $this;
    }

    /**
     * Get cylinderVolume
     *
     * @return string
     */
    public function getCylinderVolume()
    {
        return $this->cylinderVolume;
    }

    /**
     * Set boreXStroke
     *
     * @param string $boreXStroke
     *
     * @return Kendaraan
     */
    public function setBoreXStroke($boreXStroke)
    {
        $this->boreXStroke = $boreXStroke;

        return $this;
    }

    /**
     * Get boreXStroke
     *
     * @return string
     */
    public function getBoreXStroke()
    {
        return $this->boreXStroke;
    }

    /**
     * Set compressionRatio
     *
     * @param string $compressionRatio
     *
     * @return Kendaraan
     */
    public function setCompressionRatio($compressionRatio)
    {
        $this->compressionRatio = $compressionRatio;

        return $this;
    }

    /**
     * Get compressionRatio
     *
     * @return string
     */
    public function getCompressionRatio()
    {
        return $this->compressionRatio;
    }

    /**
     * Set horsePower
     *
     * @param string $horsePower
     *
     * @return Kendaraan
     */
    public function setHorsePower($horsePower)
    {
        $this->horsePower = $horsePower;

        return $this;
    }

    /**
     * Get horsePower
     *
     * @return string
     */
    public function getHorsePower()
    {
        return $this->horsePower;
    }

    /**
     * Set torque
     *
     * @param string $torque
     *
     * @return Kendaraan
     */
    public function setTorque($torque)
    {
        $this->torque = $torque;

        return $this;
    }

    /**
     * Get torque
     *
     * @return string
     */
    public function getTorque()
    {
        return $this->torque;
    }

    /**
     * Set systemStarter
     *
     * @param string $systemStarter
     *
     * @return Kendaraan
     */
    public function setSystemStarter($systemStarter)
    {
        $this->systemStarter = $systemStarter;

        return $this;
    }

    /**
     * Get systemStarter
     *
     * @return string
     */
    public function getSystemStarter()
    {
        return $this->systemStarter;
    }

    /**
     * Set systemOil
     *
     * @param string $systemOil
     *
     * @return Kendaraan
     */
    public function setSystemOil($systemOil)
    {
        $this->systemOil = $systemOil;

        return $this;
    }

    /**
     * Get systemOil
     *
     * @return string
     */
    public function getSystemOil()
    {
        return $this->systemOil;
    }

    /**
     * Set engineOilCap
     *
     * @param string $engineOilCap
     *
     * @return Kendaraan
     */
    public function setEngineOilCap($engineOilCap)
    {
        $this->engineOilCap = $engineOilCap;

        return $this;
    }

    /**
     * Get engineOilCap
     *
     * @return string
     */
    public function getEngineOilCap()
    {
        return $this->engineOilCap;
    }

    /**
     * Set fuelSystem
     *
     * @param string $fuelSystem
     *
     * @return Kendaraan
     */
    public function setFuelSystem($fuelSystem)
    {
        $this->fuelSystem = $fuelSystem;

        return $this;
    }

    /**
     * Get fuelSystem
     *
     * @return string
     */
    public function getFuelSystem()
    {
        return $this->fuelSystem;
    }

    /**
     * Set clutch
     *
     * @param string $clutch
     *
     * @return Kendaraan
     */
    public function setClutch($clutch)
    {
        $this->clutch = $clutch;

        return $this;
    }

    /**
     * Get clutch
     *
     * @return string
     */
    public function getClutch()
    {
        return $this->clutch;
    }

    /**
     * Set transmission
     *
     * @param string $transmission
     *
     * @return Kendaraan
     */
    public function setTransmission($transmission)
    {
        $this->transmission = $transmission;

        return $this;
    }

    /**
     * Get transmission
     *
     * @return string
     */
    public function getTransmission()
    {
        return $this->transmission;
    }

    /**
     * Set electricity
     *
     * @param string $electricity
     *
     * @return Kendaraan
     */
    public function setElectricity($electricity)
    {
        $this->electricity = $electricity;

        return $this;
    }

    /**
     * Get electricity
     *
     * @return string
     */
    public function getElectricity()
    {
        return $this->electricity;
    }

    /**
     * Set ignitionSystem
     *
     * @param string $ignitionSystem
     *
     * @return Kendaraan
     */
    public function setIgnitionSystem($ignitionSystem)
    {
        $this->ignitionSystem = $ignitionSystem;

        return $this;
    }

    /**
     * Get ignitionSystem
     *
     * @return string
     */
    public function getIgnitionSystem()
    {
        return $this->ignitionSystem;
    }

    /**
     * Set battery
     *
     * @param string $battery
     *
     * @return Kendaraan
     */
    public function setBattery($battery)
    {
        $this->battery = $battery;

        return $this;
    }

    /**
     * Get battery
     *
     * @return string
     */
    public function getBattery()
    {
        return $this->battery;
    }

    /**
     * Set sparkPlug
     *
     * @param string $sparkPlug
     *
     * @return Kendaraan
     */
    public function setSparkPlug($sparkPlug)
    {
        $this->sparkPlug = $sparkPlug;

        return $this;
    }

    /**
     * Get sparkPlug
     *
     * @return string
     */
    public function getSparkPlug()
    {
        return $this->sparkPlug;
    }

    /**
     * Set aktif
     *
     * @param boolean $aktif
     *
     * @return Kendaraan
     */
    public function setAktif($aktif)
    {
        $this->aktif = $aktif;

        return $this;
    }

    /**
     * Get aktif
     *
     * @return boolean
     */
    public function getAktif()
    {
        return $this->aktif;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Kendaraan
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set editedAt
     *
     * @param \DateTime $editedAt
     *
     * @return Kendaraan
     */
    public function setEditedAt($editedAt)
    {
        $this->editedAt = $editedAt;

        return $this;
    }

    /**
     * Get editedAt
     *
     * @return \DateTime
     */
    public function getEditedAt()
    {
        return $this->editedAt;
    }

    /**
     * Set editedBy
     *
     * @param \AppBundle\Entity\User $editedBy
     *
     * @return Kendaraan
     */
    public function setEditedBy(\AppBundle\Entity\User $editedBy = null)
    {
        $this->editedBy = $editedBy;

        return $this;
    }

    /**
     * Get editedBy
     *
     * @return \AppBundle\Entity\User
     */
    public function getEditedBy()
    {
        return $this->editedBy;
    }

    /**
     * Set createdBy
     *
     * @param \AppBundle\Entity\User $createdBy
     *
     * @return Kendaraan
     */
    public function setCreatedBy(\AppBundle\Entity\User $createdBy = null)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return \AppBundle\Entity\User
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set kategori
     *
     * @param \AppBundle\Entity\Kategori $kategori
     *
     * @return Kendaraan
     */
    public function setKategori(\AppBundle\Entity\Kategori $kategori = null)
    {
        $this->kategori = $kategori;

        return $this;
    }

    /**
     * Get kategori
     *
     * @return \AppBundle\Entity\Kategori
     */
    public function getKategori()
    {
        return $this->kategori;
    }

    /**
     * Add kendaraanWarna
     *
     * @param \AppBundle\Entity\KendaraanWarna $kendaraanWarna
     *
     * @return Kendaraan
     */
    public function addKendaraanWarna(\AppBundle\Entity\KendaraanWarna $kendaraanWarna)
    {
        $this->kendaraanWarnas[] = $kendaraanWarna;

        return $this;
    }

    /**
     * Remove kendaraanWarna
     *
     * @param \AppBundle\Entity\KendaraanWarna $kendaraanWarna
     */
    public function removeKendaraanWarna(\AppBundle\Entity\KendaraanWarna $kendaraanWarna)
    {
        $this->kendaraanWarnas->removeElement($kendaraanWarna);
    }

    /**
     * Get kendaraanWarnas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getKendaraanWarnas()
    {
        return $this->kendaraanWarnas;
    }

    /**
     * Add kendaraanPhoto
     *
     * @param \AppBundle\Entity\KendaraanPhoto $kendaraanPhoto
     *
     * @return Kendaraan
     */
    public function addKendaraanPhoto(\AppBundle\Entity\KendaraanPhoto $kendaraanPhoto)
    {
        $this->kendaraanPhotos[] = $kendaraanPhoto;

        return $this;
    }

    /**
     * Remove kendaraanPhoto
     *
     * @param \AppBundle\Entity\KendaraanPhoto $kendaraanPhoto
     */
    public function removeKendaraanPhoto(\AppBundle\Entity\KendaraanPhoto $kendaraanPhoto)
    {
        $this->kendaraanPhotos->removeElement($kendaraanPhoto);
    }

    /**
     * Get kendaraanPhotos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getKendaraanPhotos()
    {
        return $this->kendaraanPhotos;
    }

    /**
     * Add aksesorise
     *
     * @param \AppBundle\Entity\Aksesoris $aksesorise
     *
     * @return Kendaraan
     */
    public function addAksesorise(\AppBundle\Entity\Aksesoris $aksesorise)
    {
        $this->aksesorises[] = $aksesorise;

        return $this;
    }

    /**
     * Remove aksesorise
     *
     * @param \AppBundle\Entity\Aksesoris $aksesorise
     */
    public function removeAksesorise(\AppBundle\Entity\Aksesoris $aksesorise)
    {
        $this->aksesorises->removeElement($aksesorise);
    }

    /**
     * Get aksesorises
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAksesorises()
    {
        return $this->aksesorises;
    }
}
