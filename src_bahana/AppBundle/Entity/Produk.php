<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Blameable;
use Gedmo\Mapping\Annotation\Timestampable;
use JMS\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

/**
 * Product
 *
 * @ORM\Table(name="produk")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProdukRepository")
 */
class Produk
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(name="nama", type="string", length=150, nullable=false)
     *
     * @NotBlank()
     */
    private $nama;

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
     * @ORM\Column(name="deskripsi", type="text", nullable=true)
     */
    private $deskripsi;

    /**
     * @var boolean
     *
     * @ORM\Column(name="aktif", type="boolean", nullable=false)
     */
    private $aktif = '1';

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
     * @return Produk
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
     * @return Produk
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
     * Set deskripsi
     *
     * @param string $deskripsi
     *
     * @return Produk
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
     * Set aktif
     *
     * @param boolean $aktif
     *
     * @return Produk
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
     * @return Produk
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
     * @return Produk
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
     * @return Produk
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
     * @return Produk
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
}
