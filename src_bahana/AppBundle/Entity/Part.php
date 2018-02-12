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
 * Part
 *
 * @ORM\Table(name="part")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PartRepository")
 *
 * @UniqueEntity(fields={"nama"})
 */
class Part
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @Groups(groups={"part", "dropdown"})
     */
    private $id;

    /**
     * @ORM\Column(name="nama", type="string", length=100, unique=true, nullable=false)
     *
     * @NotBlank()
     *
     * @Groups(groups={"part", "dropdown"})
     */
    private $nama;

    /**
     * @ORM\Column(name="slug", type="string", length=255, unique=true, nullable=true)
     *
     * @Slug(fields={"nama"})
     */
    private $slug;

    /**
     * @ORM\Column(name="deskripsi", type="text", nullable=true)
     *
     * @Groups(groups={"part"})
     */
    private $deskripsi;

    /**
     * @ORM\Column(name="berat", type="float", precision=10, scale=0, nullable=false)
     *
     * @NotBlank()
     * @Type(type="numeric")
     * @GreaterThanOrEqual(value=0)
     *
     * @Groups(groups={"part"})
     */
    private $berat = 0;

    /**
     * @ORM\Column(name="harga", type="decimal", nullable=false)
     *
     * @NotBlank()
     * @Type(type="numeric")
     * @GreaterThanOrEqual(value=0)
     *
     * @Groups(groups={"part"})
     */
    private $harga = 0;

    /**
     * @var boolean
     *
     * @ORM\Column(name="aktif", type="boolean", nullable=false)
     *
     * @Groups(groups={"part"})
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\KategoriPart")
     * @ORM\JoinColumn(name="kategori_part_id", referencedColumnName="id", nullable=false)
     *
     * @NotBlank()
     *
     * @Groups(groups={"part"})
     * @MaxDepth(depth=2)
     */
    private $kategoriPart;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\PartPhoto", mappedBy="part")
     */
    private $partPhotos;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\PartUkuran", mappedBy="part")
     */
    private $partUkurans;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->partPhotos  = new \Doctrine\Common\Collections\ArrayCollection();
        $this->partUkurans = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Part
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
     * @return Part
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
     * Set deskripsi
     *
     * @param string $deskripsi
     *
     * @return Part
     */
    public function setDeskripsi($deskripsi)
    {
        $this->deskripsi = $deskripsi;

        return $this;
    }

    /**
     * Get deskripsi
     *
     * @return string
     */
    public function getDeskripsi()
    {
        return $this->deskripsi;
    }

    /**
     * Set berat
     *
     * @param float $berat
     *
     * @return Part
     */
    public function setBerat($berat)
    {
        $this->berat = $berat;

        return $this;
    }

    /**
     * Get berat
     *
     * @return float
     */
    public function getBerat()
    {
        return $this->berat;
    }

    /**
     * Set aktif
     *
     * @param boolean $aktif
     *
     * @return Part
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
     * @return Part
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
     * @return Part
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
     * @return Part
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
     * @return Part
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
     * Set kategoriPart
     *
     * @param \AppBundle\Entity\KategoriPart $kategoriPart
     *
     * @return Part
     */
    public function setKategoriPart(\AppBundle\Entity\KategoriPart $kategoriPart)
    {
        $this->kategoriPart = $kategoriPart;

        return $this;
    }

    /**
     * Get kategoriPart
     *
     * @return \AppBundle\Entity\KategoriPart
     */
    public function getKategoriPart()
    {
        return $this->kategoriPart;
    }

    /**
     * Add partPhoto
     *
     * @param \AppBundle\Entity\PartPhoto $partPhoto
     *
     * @return Part
     */
    public function addPartPhoto(\AppBundle\Entity\PartPhoto $partPhoto)
    {
        $this->partPhotos[] = $partPhoto;

        return $this;
    }

    /**
     * Remove partPhoto
     *
     * @param \AppBundle\Entity\PartPhoto $partPhoto
     */
    public function removePartPhoto(\AppBundle\Entity\PartPhoto $partPhoto)
    {
        $this->partPhotos->removeElement($partPhoto);
    }

    /**
     * Get partPhotos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPartPhotos()
    {
        return $this->partPhotos;
    }

    /**
     * Add partUkuran
     *
     * @param \AppBundle\Entity\PartUkuran $partUkuran
     *
     * @return Part
     */
    public function addPartUkuran(\AppBundle\Entity\PartUkuran $partUkuran)
    {
        $this->partUkurans[] = $partUkuran;

        return $this;
    }

    /**
     * Remove partUkuran
     *
     * @param \AppBundle\Entity\PartUkuran $partUkuran
     */
    public function removePartUkuran(\AppBundle\Entity\PartUkuran $partUkuran)
    {
        $this->partUkurans->removeElement($partUkuran);
    }

    /**
     * Get partUkurans
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPartUkurans()
    {
        return $this->partUkurans;
    }

    /**
     * Set harga
     *
     * @param string $harga
     *
     * @return Part
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
}
