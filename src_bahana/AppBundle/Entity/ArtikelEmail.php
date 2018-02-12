<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Blameable;
use Gedmo\Mapping\Annotation\Timestampable;
use JMS\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints as Bridge;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * ArtikelEmail
 *
 * @ORM\Table(name="artikel_email")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ArtikelEmailRepository")
 */
class ArtikelEmail
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
     * @var EmailSubscribe
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\EmailSubscribe", inversedBy="artikelEmails")
     * @ORM\JoinColumn(name="email_subscribe_id", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     */
    private $emailSubscribe;

    /**
     * @var Artikel
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Artikel", inversedBy="artikelEmails")
     * @ORM\JoinColumn(name="artikel_id", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     */
    private $artikel;


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
     * @return ArtikelEmail
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
     * @return ArtikelEmail
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
     * @return ArtikelEmail
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
     * @return ArtikelEmail
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
     * Set emailSubscribe
     *
     * @param \AppBundle\Entity\EmailSubscribe $emailSubscribe
     *
     * @return ArtikelEmail
     */
    public function setEmailSubscribe(\AppBundle\Entity\EmailSubscribe $emailSubscribe = null)
    {
        $this->emailSubscribe = $emailSubscribe;

        return $this;
    }

    /**
     * Get emailSubscribe
     *
     * @return \AppBundle\Entity\EmailSubscribe
     */
    public function getEmailSubscribe()
    {
        return $this->emailSubscribe;
    }

    /**
     * Set artikel
     *
     * @param \AppBundle\Entity\Artikel $artikel
     *
     * @return ArtikelEmail
     */
    public function setArtikel(\AppBundle\Entity\Artikel $artikel = null)
    {
        $this->artikel = $artikel;

        return $this;
    }

    /**
     * Get artikel
     *
     * @return \AppBundle\Entity\Artikel
     */
    public function getArtikel()
    {
        return $this->artikel;
    }
}
