<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Blameable;
use Gedmo\Mapping\Annotation\Timestampable;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\MaxDepth;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Kota
 *
 * @ORM\Table(name="kota")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\KotaRepository")
 */
class Kota
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @Groups(groups={"kota", "bookingKendaraan", "dropdown", "dealer", "hargaOTR", "bookingOrder"})
     */
    private $id;

    /**
     * @ORM\Column(name="nama", type="string", length=100, nullable=false)
     * @NotBlank()
     *
     * @Groups(groups={"kota", "bookingKendaraan", "dropdown", "dealer", "hargaOTR", "bookingOrder"})
     */
    private $nama;

    /**
     * @var boolean
     *
     * @ORM\Column(name="aktif", type="boolean", nullable=false)
     *
     * @Groups(groups={"kota"})
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
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Dealer", mappedBy="kota")
     */
    private $dealers;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Propinsi", inversedBy="kotas")
     * @ORM\JoinColumn(name="propinsi_id", referencedColumnName="id", nullable=false)
     * @NotBlank()
     *
     * @Groups(groups={"kota", "dropdown"})
     * @MaxDepth(depth=2)
     */
    private $propinsi;

    public function getAktifDealer()
    {
        $criteria = Criteria::create()->andWhere(Criteria::expr()->eq("aktif", true));

        return $this->dealers->matching($criteria);
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dealers = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Kota
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
     * Set aktif
     *
     * @param boolean $aktif
     *
     * @return Kota
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
     * @return Kota
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
     * @return Kota
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
     * @return Kota
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
     * @return Kota
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
     * Add dealer
     *
     * @param \AppBundle\Entity\Dealer $dealer
     *
     * @return Kota
     */
    public function addDealer(\AppBundle\Entity\Dealer $dealer)
    {
        $this->dealers[] = $dealer;

        return $this;
    }

    /**
     * Remove dealer
     *
     * @param \AppBundle\Entity\Dealer $dealer
     */
    public function removeDealer(\AppBundle\Entity\Dealer $dealer)
    {
        $this->dealers->removeElement($dealer);
    }

    /**
     * Get dealers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDealers()
    {
        return $this->dealers;
    }

    /**
     * Set propinsi
     *
     * @param \AppBundle\Entity\Propinsi $propinsi
     *
     * @return Kota
     */
    public function setPropinsi(\AppBundle\Entity\Propinsi $propinsi)
    {
        $this->propinsi = $propinsi;

        return $this;
    }

    /**
     * Get propinsi
     *
     * @return \AppBundle\Entity\Propinsi
     */
    public function getPropinsi()
    {
        return $this->propinsi;
    }
}
