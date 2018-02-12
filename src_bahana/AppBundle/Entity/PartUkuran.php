<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Blameable;
use Gedmo\Mapping\Annotation\Timestampable;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\MaxDepth;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * PartUkuran
 *
 * @ORM\Table(name="part_ukuran")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PartUkuranRepository")
 */
class PartUkuran
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @Groups(groups={"partUkuran", "partFront", "dropdown"})
     */
    private $id;

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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Part", inversedBy="partUkurans")
     * @ORM\JoinColumn(name="part_id", referencedColumnName="id", nullable=true)
     *
     * @NotBlank()
     */
    private $part;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Ukuran")
     * @ORM\JoinColumn(name="ukuran_id", referencedColumnName="id", nullable=true)
     *
     * @NotBlank()
     *
     * @Groups(groups={"partUkuran", "partFront"})
     * @MaxDepth(depth=2)
     */
    private $ukuran;

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
     * @return PartUkuran
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
     * @return PartUkuran
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
     * @return PartUkuran
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
     * @return PartUkuran
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
     * Set part
     *
     * @param \AppBundle\Entity\Part $part
     *
     * @return PartUkuran
     */
    public function setPart(\AppBundle\Entity\Part $part = null)
    {
        $this->part = $part;

        return $this;
    }

    /**
     * Get part
     *
     * @return \AppBundle\Entity\Part
     */
    public function getPart()
    {
        return $this->part;
    }

    /**
     * Set ukuran
     *
     * @param \AppBundle\Entity\Ukuran $ukuran
     *
     * @return PartUkuran
     */
    public function setUkuran(\AppBundle\Entity\Ukuran $ukuran = null)
    {
        $this->ukuran = $ukuran;

        return $this;
    }

    /**
     * Get ukuran
     *
     * @return \AppBundle\Entity\Ukuran
     */
    public function getUkuran()
    {
        return $this->ukuran;
    }
}
