<?php

namespace AppBundle\Entity;

use AppBundle\Lib\FileUploadLib;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Mapping\Annotation\Blameable;
use Gedmo\Mapping\Annotation\Slug;
use Gedmo\Mapping\Annotation\Timestampable;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\Groups;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Artikel
 *
 * @ORM\Table(name="artikel")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ArtikelRepository")
 * @Gedmo\Uploadable(pathMethod="getPath", filenameGenerator="SHA1", allowOverwrite=true, appendNumber=true)
 */
class Artikel
{
    /**
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @Groups(groups={"artikel"})
     */
    private $id;

    /**
     * @ORM\Column(name="foto", type="string", length=255, nullable=true)
     * @Gedmo\UploadableFileName()
     */
    private $foto;

    /**
     * @Slug(fields={"judul"})
     * @ORM\Column(name="slug", type="string", length=128, unique=true)
     * @Groups({"front", "artikel"})
     */
    private $slug;

    /**
     * @ORM\Column(name="judul", type="string", length=255, nullable=false)
     *
     * @NotBlank()
     *
     * @Groups({"front", "artikel"})
     */
    private $judul;

    /**
     * @ORM\Column(name="caption", type="text", nullable=false)
     *
     * @NotBlank()
     * @Length(min="10")
     *
     * @Groups({"front", "artikel"})
     */
    private $caption;

    /**
     * @ORM\Column(name="isi", type="text", nullable=false)
     *
     * @NotBlank()
     * @Length(min="10")
     *
     * @Groups({"front", "artikel"})
     */
    private $isi;

    /**
     * @ORM\Column(name="sumber", type="string", length=255, nullable=false)
     *
     * @NotBlank()
     *
     * @Groups({"front", "artikel"})
     */
    private $sumber;

    /**
     * @ORM\Column(name="aktif", type="boolean", nullable=false)
     *
     * @Groups({"artikel"})
     */
    private $aktif = true;

    /**
     * @ORM\Column(name="mark_for_blast", type="boolean", nullable=false)
     *
     * @Groups({"artikel"})
     */
    private $markForBlast = false;

    /**
     * @ORM\Column(name="blasted_at", type="datetime", nullable=true)
     *
     * @Groups({"artikel"})
     */
    private $blastedAt;

    /**
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     * @Timestampable(on="create")
     * @Groups({"front"})
     */
    private $createdAt;

    /**
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     * @Timestampable(on="update")
     * @Groups({"front"})
     */
    private $updatedAt;

    /**
     * @Blameable(on="create")
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id", nullable=true)
     */
    private $createdBy;

    /**
     * @Blameable(on="update")
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="updated_by", referencedColumnName="id", nullable=true)
     */
    private $updatedBy;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ArtikelEmail", mappedBy="artikel")
     */
    private $artikelEmails;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\KategoriNews", inversedBy="artikels")
     * @ORM\JoinColumn(name="kategori_news_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     *
     * @NotBlank()
     *
     * @Groups({"artikel"})
     * @Serializer\MaxDepth(depth=1)
     */
    private $kategoriNews;

    /**
     * @var UploadedFile
     * @NotBlank(groups={"create"})
     * @Assert\Image()
     */
    private $file;

    /**
     * @Serializer\VirtualProperty()
     * @Groups({"artikel"})
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
        return 'img/artikel';
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
        $this->artikelEmails = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set foto
     *
     * @param string $foto
     *
     * @return Artikel
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
     * @return Artikel
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
     * Set judul
     *
     * @param string $judul
     *
     * @return Artikel
     */
    public function setJudul($judul)
    {
        $this->judul = $judul;

        return $this;
    }

    /**
     * Get judul
     *
     * @return string
     */
    public function getJudul()
    {
        return $this->judul;
    }

    /**
     * Set caption
     *
     * @param string $caption
     *
     * @return Artikel
     */
    public function setCaption($caption)
    {
        $this->caption = $caption;

        return $this;
    }

    /**
     * Get caption
     *
     * @return string
     */
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * Set isi
     *
     * @param string $isi
     *
     * @return Artikel
     */
    public function setIsi($isi)
    {
        $this->isi = $isi;

        return $this;
    }

    /**
     * Get isi
     *
     * @return string
     */
    public function getIsi()
    {
        return $this->isi;
    }

    /**
     * Set sumber
     *
     * @param string $sumber
     *
     * @return Artikel
     */
    public function setSumber($sumber)
    {
        $this->sumber = $sumber;

        return $this;
    }

    /**
     * Get sumber
     *
     * @return string
     */
    public function getSumber()
    {
        return $this->sumber;
    }

    /**
     * Set aktif
     *
     * @param boolean $aktif
     *
     * @return Artikel
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
     * Set markForBlast
     *
     * @param boolean $markForBlast
     *
     * @return Artikel
     */
    public function setMarkForBlast($markForBlast)
    {
        $this->markForBlast = $markForBlast;

        return $this;
    }

    /**
     * Get markForBlast
     *
     * @return boolean
     */
    public function getMarkForBlast()
    {
        return $this->markForBlast;
    }

    /**
     * Set blastedAt
     *
     * @param \DateTime $blastedAt
     *
     * @return Artikel
     */
    public function setBlastedAt($blastedAt)
    {
        $this->blastedAt = $blastedAt;

        return $this;
    }

    /**
     * Get blastedAt
     *
     * @return \DateTime
     */
    public function getBlastedAt()
    {
        return $this->blastedAt;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Artikel
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
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Artikel
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set createdBy
     *
     * @param \AppBundle\Entity\User $createdBy
     *
     * @return Artikel
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
     * Set updatedBy
     *
     * @param \AppBundle\Entity\User $updatedBy
     *
     * @return Artikel
     */
    public function setUpdatedBy(\AppBundle\Entity\User $updatedBy = null)
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    /**
     * Get updatedBy
     *
     * @return \AppBundle\Entity\User
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    /**
     * Add artikelEmail
     *
     * @param \AppBundle\Entity\ArtikelEmail $artikelEmail
     *
     * @return Artikel
     */
    public function addArtikelEmail(\AppBundle\Entity\ArtikelEmail $artikelEmail)
    {
        $this->artikelEmails[] = $artikelEmail;

        return $this;
    }

    /**
     * Remove artikelEmail
     *
     * @param \AppBundle\Entity\ArtikelEmail $artikelEmail
     */
    public function removeArtikelEmail(\AppBundle\Entity\ArtikelEmail $artikelEmail)
    {
        $this->artikelEmails->removeElement($artikelEmail);
    }

    /**
     * Get artikelEmails
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArtikelEmails()
    {
        return $this->artikelEmails;
    }

    /**
     * Set kategoriNews
     *
     * @param \AppBundle\Entity\KategoriNews $kategoriNews
     *
     * @return Artikel
     */
    public function setKategoriNews(\AppBundle\Entity\KategoriNews $kategoriNews = null)
    {
        $this->kategoriNews = $kategoriNews;

        return $this;
    }

    /**
     * Get kategoriNews
     *
     * @return \AppBundle\Entity\KategoriNews
     */
    public function getKategoriNews()
    {
        return $this->kategoriNews;
    }
}
