<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Mapping\Annotation\Blameable;
use Gedmo\Mapping\Annotation\Timestampable;
use JMS\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * KategoriNews
 *
 * @ORM\Table(name="kategori_news")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\KategoriNewsRepository")
 */
class KategoriNews
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @Groups(groups={"kategoriNews", "dropdown", "service", "bookingOrder", "artikel"})
     */
    private $id;

    /**
     * @ORM\Column(name="slug", type="string", length=150, nullable=false)
     *
     * @Gedmo\Slug(fields={"nama"})
     *
     * @Groups(groups={"kategoriNews", "dropdown", "service", "bookingOrder", "artikel"})
     */
    private $slug;

    /**
     * @ORM\Column(name="nama", type="string", length=150, nullable=false)
     *
     * @NotBlank()
     *
     * @Groups(groups={"kategoriNews", "dropdown", "service", "bookingOrder", "artikel"})
     */
    private $nama;

    /**
     * @ORM\Column(name="aktif", type="boolean", nullable=false)
     *
     * @Groups(groups={"kategoriNews"})
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
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Artikel", mappedBy="kategoriNews")
     */
    private $artikels;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->artikels = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set slug
     *
     * @param string $slug
     *
     * @return KategoriNews
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
     * Set nama
     *
     * @param string $nama
     *
     * @return KategoriNews
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
     * @return KategoriNews
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
     * @return KategoriNews
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
     * @return KategoriNews
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
     * @return KategoriNews
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
     * @return KategoriNews
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
     * Add artikel
     *
     * @param \AppBundle\Entity\Artikel $artikel
     *
     * @return KategoriNews
     */
    public function addArtikel(\AppBundle\Entity\Artikel $artikel)
    {
        $this->artikels[] = $artikel;

        return $this;
    }

    /**
     * Remove artikel
     *
     * @param \AppBundle\Entity\Artikel $artikel
     */
    public function removeArtikel(\AppBundle\Entity\Artikel $artikel)
    {
        $this->artikels->removeElement($artikel);
    }

    /**
     * Get artikels
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArtikels()
    {
        return $this->artikels;
    }
}
