<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Blameable;
use Gedmo\Mapping\Annotation\Timestampable;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\MaxDepth;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

/**
 * HargaOTR
 *
 * @ORM\Table(name="harga_otr")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\HargaOTRRepository")
 */
class HargaOTR
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @Groups(groups={"hargaOTR", "bookingKendaraan", "dropdown", "dealer"})
     */
    private $id;

    /**
     * @ORM\Column(name="harga", type="decimal", nullable=false)
     *
     * @NotBlank()
     * @Type(type="numeric")
     * @GreaterThanOrEqual(value=0)
     *
     * @Groups(groups={"hargaOTR", "bookingKendaraan"})
     */
    private $harga;

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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Kota")
     * @ORM\JoinColumn(name="kota_id", referencedColumnName="id", nullable=true)
     *
     * @NotBlank()
     *
     * @Groups(groups={"hargaOTR", "bookingKendaraan"})
     * @MaxDepth(depth=2)
     */
    private $kota;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Kendaraan")
     * @ORM\JoinColumn(name="kendaraan_id", referencedColumnName="id", nullable=true)
     *
     * @NotBlank()
     *
     * @Groups(groups={"hargaOTR"})
     * @MaxDepth(depth=2)
     */
    private $kendaraan;

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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return HargaOTR
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
     * @return HargaOTR
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
     * @return HargaOTR
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
     * @return HargaOTR
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
     * @return HargaOTR
     */
    public function setKota(\AppBundle\Entity\Kota $kota = null)
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
     * Set kendaraan
     *
     * @param \AppBundle\Entity\Kendaraan $kendaraan
     *
     * @return HargaOTR
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
     * Set harga
     *
     * @param string $harga
     *
     * @return HargaOTR
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
