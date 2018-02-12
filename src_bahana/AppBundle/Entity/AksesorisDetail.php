<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Blameable;
use Gedmo\Mapping\Annotation\Timestampable;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\MaxDepth;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * AksesorisDetail
 *
 * @ORM\Table(name="aksesoris_detail")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AksesorisDetailRepository")
 */
class AksesorisDetail
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @Groups(groups={"aksesorisDetail", "aksesorisFront", "dropdown"})
     */
    private $id;

    /**
     * @ORM\Column(name="kode", type="string", length=50, nullable=false)
     *
     * @NotBlank()
     *
     * @Groups(groups={"aksesorisDetail", "aksesorisFront", "dropdown"})
     */
    private $kode;

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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Aksesoris", inversedBy="aksesorisDetails")
     * @ORM\JoinColumn(name="aksesoris_id", referencedColumnName="id", nullable=true)
     *
     * @NotBlank()
     */
    private $aksesoris;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Warna")
     * @ORM\JoinColumn(name="warna_id", referencedColumnName="id", nullable=true)
     *
     * @NotBlank()
     *
     * @Groups(groups={"aksesorisDetail", "aksesorisFront"})
     * @MaxDepth(depth=2)
     */
    private $warna;

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
     * Set kode
     *
     * @param string $kode
     *
     * @return AksesorisDetail
     */
    public function setKode($kode)
    {
        $this->kode = $kode;

        return $this;
    }

    /**
     * Get kode
     *
     * @return string
     */
    public function getKode()
    {
        return $this->kode;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return AksesorisDetail
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
     * @return AksesorisDetail
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
     * @return AksesorisDetail
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
     * @return AksesorisDetail
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
     * Set aksesoris
     *
     * @param \AppBundle\Entity\Aksesoris $aksesoris
     *
     * @return AksesorisDetail
     */
    public function setAksesoris(\AppBundle\Entity\Aksesoris $aksesoris = null)
    {
        $this->aksesoris = $aksesoris;

        return $this;
    }

    /**
     * Get aksesoris
     *
     * @return \AppBundle\Entity\Aksesoris
     */
    public function getAksesoris()
    {
        return $this->aksesoris;
    }

    /**
     * Set warna
     *
     * @param \AppBundle\Entity\Warna $warna
     *
     * @return AksesorisDetail
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
}
