<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Blameable;
use Gedmo\Mapping\Annotation\Timestampable;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\MaxDepth;
use JMS\Serializer\Annotation\VirtualProperty;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Dealer
 *
 * @ORM\Table(name="dealer")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DealerRepository")
 */
class Dealer
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @Groups(groups={"dealer", "dropdown", "service", "bookingOrder"})
     */
    private $id;

    /**
     * @ORM\Column(name="nama", type="string", length=150, nullable=false)
     *
     * @NotBlank()
     *
     * @Groups(groups={"dealer", "dropdown", "service", "bookingOrder"})
     */
    private $nama;

    /**
     * @ORM\Column(name="alamat", type="text", nullable=true)
     *
     * @NotBlank()
     *
     * @Groups(groups={"dealer"})
     */
    private $alamat;

    /**
     * @ORM\Column(name="telepon", type="string", length=100, nullable=true)
     *
     * @NotBlank()
     *
     * @Groups(groups={"dealer"})
     */
    private $telepon;

    /**
     * @ORM\Column(name="email", type="string", length=150, nullable=true)
     *
     * @NotBlank()
     * @Email()
     *
     * @Groups(groups={"dealer"})
     */
    private $email;

    /**
     * @ORM\Column(name="email_sales", type="string", length=150, nullable=true)
     *
     * @NotBlank()
     * @Email()
     *
     * @Groups(groups={"dealer"})
     */
    private $emailSales;

    /**
     * @ORM\Column(name="email_service", type="string", length=150, nullable=true)
     *
     * @NotBlank()
     * @Email()
     *
     * @Groups(groups={"dealer"})
     */
    private $emailService;

    /**
     * @ORM\Column(name="fax", type="string", length=100, nullable=true)
     *
     * @NotBlank()
     *
     * @Groups(groups={"dealer"})
     */
    private $fax;

    /**
     * @ORM\Column(name="longitude", type="string", length=50, nullable=true)
     *
     * @NotBlank()
     *
     * @Groups(groups={"dealer"})
     */
    private $longitude;

    /**
     * @ORM\Column(name="latitude", type="string", length=50, nullable=true)
     *
     * @NotBlank()
     *
     * @Groups(groups={"dealer"})
     */
    private $latitude;

    /**
     * @ORM\Column(name="zoom_point", type="string", length=50, nullable=true)
     *
     * @NotBlank()
     *
     * @Groups(groups={"dealer"})
     */
    private $zoomPoint;

    /**
     * @ORM\Column(name="aktif", type="boolean", nullable=false)
     *
     * @Groups(groups={"dealer"})
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Kota", inversedBy="dealers")
     * @ORM\JoinColumn(name="kota_id", referencedColumnName="id", nullable=false)
     *
     * @NotBlank()
     *
     * @Groups(groups={"dealer", "dropdown", "bookingOrder"})
     * @MaxDepth(depth=2)
     */
    private $kota;

    /**
     * @VirtualProperty()
     */
    public function linkGMap()
    {
        return "https://www.google.com/maps/place/" . $this->getLatitude() . "," . $this->getLongitude();
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
     * @return Dealer
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
     * Set alamat
     *
     * @param string $alamat
     *
     * @return Dealer
     */
    public function setAlamat($alamat)
    {
        $this->alamat = $alamat;

        return $this;
    }

    /**
     * Get alamat
     *
     * @return string
     */
    public function getAlamat()
    {
        return $this->alamat;
    }

    /**
     * Set telepon
     *
     * @param string $telepon
     *
     * @return Dealer
     */
    public function setTelepon($telepon)
    {
        $this->telepon = $telepon;

        return $this;
    }

    /**
     * Get telepon
     *
     * @return string
     */
    public function getTelepon()
    {
        return $this->telepon;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Dealer
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set fax
     *
     * @param string $fax
     *
     * @return Dealer
     */
    public function setFax($fax)
    {
        $this->fax = $fax;

        return $this;
    }

    /**
     * Get fax
     *
     * @return string
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     *
     * @return Dealer
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     *
     * @return Dealer
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set zoomPoint
     *
     * @param string $zoomPoint
     *
     * @return Dealer
     */
    public function setZoomPoint($zoomPoint)
    {
        $this->zoomPoint = $zoomPoint;

        return $this;
    }

    /**
     * Get zoomPoint
     *
     * @return string
     */
    public function getZoomPoint()
    {
        return $this->zoomPoint;
    }

    /**
     * Set aktif
     *
     * @param boolean $aktif
     *
     * @return Dealer
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
     * @return Dealer
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
     * @return Dealer
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
     * @return Dealer
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
     * @return Dealer
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
     * Set kota
     *
     * @param \AppBundle\Entity\Kota $kota
     *
     * @return Dealer
     */
    public function setKota(\AppBundle\Entity\Kota $kota)
    {
        $this->kota = $kota;

        return $this;
    }

    /**
     * Get kota
     *
     * @return \AppBundle\Entity\Kota
     */
    public function getKota()
    {
        return $this->kota;
    }

    /**
     * Set emailSales
     *
     * @param string $emailSales
     *
     * @return Dealer
     */
    public function setEmailSales($emailSales)
    {
        $this->emailSales = $emailSales;

        return $this;
    }

    /**
     * Get emailSales
     *
     * @return string
     */
    public function getEmailSales()
    {
        return $this->emailSales;
    }

    /**
     * Set emailService
     *
     * @param string $emailService
     *
     * @return Dealer
     */
    public function setEmailService($emailService)
    {
        $this->emailService = $emailService;

        return $this;
    }

    /**
     * Get emailService
     *
     * @return string
     */
    public function getEmailService()
    {
        return $this->emailService;
    }
}
