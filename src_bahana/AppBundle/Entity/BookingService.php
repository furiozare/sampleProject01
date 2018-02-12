<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Blameable;
use Gedmo\Mapping\Annotation\Timestampable;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\MaxDepth;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * BookingService
 *
 * @ORM\Table(name="booking_service")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BookingServiceRepository")
 */
class BookingService
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @Groups(groups={"service"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nama", type="string", length=150, nullable=false)
     *
     * @NotBlank()
     *
     * @Groups(groups={"service"})
     */
    private $nama;

    /**
     * @var string
     *
     * @ORM\Column(name="no_polisi", type="string", length=100, nullable=false)
     *
     * @NotBlank()
     *
     * @Groups(groups={"service"})
     */
    private $noPolisi;

    /**
     * @var string
     *
     * @ORM\Column(name="telepon", type="string", length=100, nullable=false)
     *
     * @NotBlank()
     *
     * @Groups(groups={"service"})
     */
    private $telepon;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=200, nullable=false)
     *
     * @NotBlank()
     * @Email()
     *
     * @Groups(groups={"service"})
     */
    private $email;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="tanggal_waktu", type="datetime", nullable=false)
     *
     * @NotBlank()
     * @DateTime()
     *
     * @Groups(groups={"service"})
     */
    private $tanggalWaktu;

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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Dealer")
     * @ORM\JoinColumn(name="dealer_id", referencedColumnName="id", nullable=false)
     *
     * @NotBlank()
     *
     * @Groups(groups={"service"})
     * @MaxDepth(depth=2)
     */
    private $dealer;

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
     * @return BookingService
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
     * Set noPolisi
     *
     * @param string $noPolisi
     *
     * @return BookingService
     */
    public function setNoPolisi($noPolisi)
    {
        $this->noPolisi = $noPolisi;

        return $this;
    }

    /**
     * Get noPolisi
     *
     * @return string
     */
    public function getNoPolisi()
    {
        return $this->noPolisi;
    }

    /**
     * Set telepon
     *
     * @param string $telepon
     *
     * @return BookingService
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
     * @return BookingService
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
     * Set tanggalWaktu
     *
     * @param \DateTime $tanggalWaktu
     *
     * @return BookingService
     */
    public function setTanggalWaktu($tanggalWaktu)
    {
        $this->tanggalWaktu = $tanggalWaktu;

        return $this;
    }

    /**
     * Get tanggalWaktu
     *
     * @return \DateTime
     */
    public function getTanggalWaktu()
    {
        return $this->tanggalWaktu;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return BookingService
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
     * @return BookingService
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
     * @return BookingService
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
     * @return BookingService
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
     * Set dealer
     *
     * @param \AppBundle\Entity\Dealer $dealer
     *
     * @return BookingService
     */
    public function setDealer(\AppBundle\Entity\Dealer $dealer)
    {
        $this->dealer = $dealer;

        return $this;
    }

    /**
     * Get dealer
     *
     * @return \AppBundle\Entity\Dealer
     */
    public function getDealer()
    {
        return $this->dealer;
    }
}
