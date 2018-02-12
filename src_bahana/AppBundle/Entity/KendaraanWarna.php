<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Blameable;
use Gedmo\Mapping\Annotation\Timestampable;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\MaxDepth;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * KendaraanWarna
 *
 * @ORM\Table(name="kendaraan_warna")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\KendaraanWarnaRepository")
 */
class KendaraanWarna
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @Groups(groups={"kendaraanWarna", "kendaraanDetail", "bookingOrder"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Warna")
     * @ORM\JoinColumn(name="warna_id", referencedColumnName="id", nullable=true)
     *
     * @NotBlank()
     *
     * @Groups(groups={"kendaraanWarna", "kendaraanDetail", "bookingOrder"})
     * @MaxDepth(depth=2)
     */
    private $warna;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Kendaraan")
     * @ORM\JoinColumn(name="kendaraan_id", referencedColumnName="id", nullable=true)
     *
     * @NotBlank()
     *
     * @Groups(groups={"kendaraanWarna", "kendaraanDetail", "bookingOrder"})
     * @MaxDepth(depth=2)
     */
    private $kendaraan;

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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return KendaraanWarna
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
     * @return KendaraanWarna
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
     * Set warna
     *
     * @param \AppBundle\Entity\Warna $warna
     *
     * @return KendaraanWarna
     */
    public function setWarna(\AppBundle\Entity\Warna $warna = null)
    {
        $this->warna = $warna;

        return $this;
    }

    /**
     * Get warna
     *
     * @return \AppBundle\Entity\Warna
     */
    public function getWarna()
    {
        return $this->warna;
    }

    /**
     * Set kendaraan
     *
     * @param \AppBundle\Entity\Kendaraan $kendaraan
     *
     * @return KendaraanWarna
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
     * Set editedBy
     *
     * @param \AppBundle\Entity\User $editedBy
     *
     * @return KendaraanWarna
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
     * @return KendaraanWarna
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
