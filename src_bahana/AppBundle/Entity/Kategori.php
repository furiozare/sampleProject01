<?php

namespace AppBundle\Entity;

use AppBundle\Lib\FileUploadLib;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Blameable;
use Gedmo\Mapping\Annotation\Slug;
use Gedmo\Mapping\Annotation\Timestampable;
use Gedmo\Mapping\Annotation\Uploadable;
use Gedmo\Mapping\Annotation\UploadableFileName;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Kategori
 *
 * @ORM\Table(name="kategori")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\KategoriRepository")
 * @Uploadable(pathMethod="getPath", filenameGenerator="SHA1", allowOverwrite=true, appendNumber=true)
 */
class Kategori
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @Groups(groups={"kategori", "dropdown", "kendaraan", "bookingOrder"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nama", type="string", length=150, nullable=false)
     *
     * @NotBlank()
     *
     * @Groups(groups={"kategori", "dropdown", "kendaraan", "bookingOrder"})
     */
    private $nama;

    /**
     * @ORM\Column(name="foto", type="string", length=255, nullable=true)
     * @UploadableFileName()
     */
    private $foto;

    /**
     * @ORM\Column(name="slug", type="string", length=255, unique=true, nullable=true)
     *
     * @Slug(fields={"nama"})
     */
    private $slug;

    /**
     * @ORM\Column(name="kendaraan", type="boolean", nullable=false)
     *
     * @Groups(groups={"kategori"})
     */
    private $kendaraan = false;

    /**
     * @ORM\Column(name="aktif", type="boolean", nullable=false)
     *
     * @Groups(groups={"kategori"})
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
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Kendaraan", mappedBy="kategori")
     */
    private $kendaraans;

    /**
     * @var UploadedFile
     * @NotBlank(groups={"create"})
     * @Image()
     */
    private $file;

    /**
     * @VirtualProperty()
     * @Groups({"kategori"})
     */
    public function url()
    {
        return $this->getWebUrl();
    }

    /**
     * @return string
     */
    public function getRootDir()
    {
        return 'img/kategori';
    }

    public function getWebUrl()
    {
        return $this->getRootDir() . '/' . $this->getFoto();
    }

    public function getPath()
    {
        return FileUploadLib::GET_PUBLIC_ROOT_DIR() . $this->getRootDir();
    }

    /**
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param UploadedFile $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->kendaraans = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Kategori
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
     * Set foto
     *
     * @param string $foto
     *
     * @return Kategori
     */
    public function setFoto($foto)
    {
        $this->foto = $foto;

        return $this;
    }

    /**
     * Get foto
     *
     * @return string
     */
    public function getFoto()
    {
        return $this->foto;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Kategori
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
     * Set kendaraan
     *
     * @param boolean $kendaraan
     *
     * @return Kategori
     */
    public function setKendaraan($kendaraan)
    {
        $this->kendaraan = $kendaraan;

        return $this;
    }

    /**
     * Get kendaraan
     *
     * @return boolean
     */
    public function getKendaraan()
    {
        return $this->kendaraan;
    }

    /**
     * Set aktif
     *
     * @param boolean $aktif
     *
     * @return Kategori
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
     * @return Kategori
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
     * @return Kategori
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
     * @return Kategori
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
     * @return Kategori
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
     * Add kendaraan
     *
     * @param \AppBundle\Entity\Kendaraan $kendaraan
     *
     * @return Kategori
     */
    public function addKendaraan(\AppBundle\Entity\Kendaraan $kendaraan)
    {
        $this->kendaraans[] = $kendaraan;

        return $this;
    }

    /**
     * Remove kendaraan
     *
     * @param \AppBundle\Entity\Kendaraan $kendaraan
     */
    public function removeKendaraan(\AppBundle\Entity\Kendaraan $kendaraan)
    {
        $this->kendaraans->removeElement($kendaraan);
    }

    /**
     * Get kendaraans
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getKendaraans()
    {
        return $this->kendaraans;
    }
}
