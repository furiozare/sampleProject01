<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Blameable;
use Gedmo\Mapping\Annotation\Timestampable;
use JMS\Serializer\Annotation\Groups;

/**
 * Propinsi
 *
 * @ORM\Table(name="propinsi")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PropinsiRepository")
 */
class Propinsi
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @Groups(groups={"propinsi", "kota", "dropdown"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nama", type="string", length=100, nullable=false)
     *
     * @Groups(groups={"propinsi", "kota", "dropdown"})
     */
    private $nama;

    /**
     * @var boolean
     *
     * @ORM\Column(name="aktif", type="boolean", nullable=false)
     *
     * @Groups(groups={"propinsi"})
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
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Kota", mappedBy="propinsi")
     */
    private $kotas;

    public function getAktifKota()
    {
        $criteria = Criteria::create()->andWhere(Criteria::expr()->eq("aktif", true));

        return $this->kotas->matching($criteria);
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->kotas = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Propinsi
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
     * @return Propinsi
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
     * @return Propinsi
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
     * @return Propinsi
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
     * @return Propinsi
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
     * @return Propinsi
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
     * Add kota
     *
     * @param \AppBundle\Entity\Kota $kota
     *
     * @return Propinsi
     */
    public function addKota(\AppBundle\Entity\Kota $kota)
    {
        $this->kotas[] = $kota;

        return $this;
    }

    /**
     * Remove kota
     *
     * @param \AppBundle\Entity\Kota $kota
     */
    public function removeKota(\AppBundle\Entity\Kota $kota)
    {
        $this->kotas->removeElement($kota);
    }

    /**
     * Get kotas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getKotas()
    {
        return $this->kotas;
    }
}
