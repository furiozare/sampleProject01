<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Blameable;
use Gedmo\Mapping\Annotation\Slug;
use Gedmo\Mapping\Annotation\Timestampable;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\MaxDepth;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

/**
 * Aksesoris
 *
 * @ORM\Table(name="aksesoris")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AksesorisRepository")
 */
class Aksesoris
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @Groups(groups={"aksesoris", "aksesorisFront", "dropdown"})
     */
    private $id;

    /**
     * @ORM\Column(name="nama", type="string", length=150, nullable=false)
     *
     * @NotBlank()
     *
     * @Groups(groups={"aksesoris", "aksesorisFront", "dropdown"})
     */
    private $nama;

    /**
     * @ORM\Column(name="slug", type="string", length=255, unique=true, nullable=true)
     *
     * @Slug(fields={"nama"})
     */
    private $slug;

    /**
     * @ORM\Column(name="harga", type="decimal", nullable=false)
     *
     * @NotBlank()
     * @Type(type="numeric")
     * @GreaterThanOrEqual(value=0)
     *
     * @Groups(groups={"aksesoris", "aksesorisFront"})
     */
    private $harga;

    /**
     * @ORM\Column(name="aktif", type="boolean", nullable=false)
     *
     * @Groups(groups={"aksesoris"})
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Kendaraan", inversedBy="aksesorises")
     * @ORM\JoinColumn(name="kendaraan_id", referencedColumnName="id", nullable=true)
     *
     * @NotBlank()
     */
    private $kendaraan;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AksesorisDetail", mappedBy="aksesoris")
     * @Groups(groups={"aksesorisFront"})
     * @MaxDepth(depth=2)
     */
    private $aksesorisDetails;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AksesorisPhoto", mappedBy="aksesoris")
     * @Groups(groups={"aksesorisFront"})
     * @MaxDepth(depth=2)
     */
    private $aksesorisPhotos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->aksesorisDetails = new \Doctrine\Common\Collections\ArrayCollection();
        $this->aksesorisPhotos  = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Aksesoris
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
     * Set harga
     *
     * @param string $harga
     *
     * @return Aksesoris
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
     * Set aktif
     *
     * @param boolean $aktif
     *
     * @return Aksesoris
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
     * @return Aksesoris
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
     * @return Aksesoris
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
     * @return Aksesoris
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
     * @return Aksesoris
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
     * Set kendaraan
     *
     * @param \AppBundle\Entity\Kendaraan $kendaraan
     *
     * @return Aksesoris
     */
    public function setKendaraan(\AppBundle\Entity\Kendaraan $kendaraan = null)
    {
        $this->kendaraan = $kendaraan;

        return $this;
    }

    /**
     * Get kendaraan
     *
     * @return \AppBundle\Entity\Kendaraan
     */
    public function getKendaraan()
    {
        return $this->kendaraan;
    }

    /**
     * Add aksesorisDetail
     *
     * @param \AppBundle\Entity\AksesorisDetail $aksesorisDetail
     *
     * @return Aksesoris
     */
    public function addAksesorisDetail(\AppBundle\Entity\AksesorisDetail $aksesorisDetail)
    {
        $this->aksesorisDetails[] = $aksesorisDetail;

        return $this;
    }

    /**
     * Remove aksesorisDetail
     *
     * @param \AppBundle\Entity\AksesorisDetail $aksesorisDetail
     */
    public function removeAksesorisDetail(\AppBundle\Entity\AksesorisDetail $aksesorisDetail)
    {
        $this->aksesorisDetails->removeElement($aksesorisDetail);
    }

    /**
     * Get aksesorisDetails
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAksesorisDetails()
    {
        return $this->aksesorisDetails;
    }

    /**
     * Add aksesorisPhoto
     *
     * @param \AppBundle\Entity\AksesorisPhoto $aksesorisPhoto
     *
     * @return Aksesoris
     */
    public function addAksesorisPhoto(\AppBundle\Entity\AksesorisPhoto $aksesorisPhoto)
    {
        $this->aksesorisPhotos[] = $aksesorisPhoto;

        return $this;
    }

    /**
     * Remove aksesorisPhoto
     *
     * @param \AppBundle\Entity\AksesorisPhoto $aksesorisPhoto
     */
    public function removeAksesorisPhoto(\AppBundle\Entity\AksesorisPhoto $aksesorisPhoto)
    {
        $this->aksesorisPhotos->removeElement($aksesorisPhoto);
    }

    /**
     * Get aksesorisPhotos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAksesorisPhotos()
    {
        return $this->aksesorisPhotos;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Aksesoris
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
}
