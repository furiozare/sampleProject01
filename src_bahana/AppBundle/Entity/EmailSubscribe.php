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
 * EmailSubscribe
 *
 * @ORM\Table(name="email_subscribe")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EmailSubscribeRepository")
 * @Bridge\UniqueEntity(fields={"email"})
 */
class EmailSubscribe
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @Groups(groups={"emailSubscribe", "dropdown", "service", "bookingOrder"})
     */
    private $id;

    /**
     * @ORM\Column(name="email", type="string", length=150, nullable=false, unique=true)
     *
     * @NotBlank()
     * @Email()
     *
     * @Groups(groups={"emailSubscribe"})
     */
    private $email;

    /**
     * @ORM\Column(name="aktif", type="boolean", nullable=false)
     *
     * @Groups(groups={"emailSubscribe"})
     */
    private $aktif = true;

    /**
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     * @Timestampable(on="create")
     *
     * @Groups(groups={"emailSubscribe"})
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
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ArtikelEmail", mappedBy="emailSubscribe")
     */
    private $artikelEmails;
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
     * Set email
     *
     * @param string $email
     *
     * @return EmailSubscribe
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set aktif
     *
     * @param boolean $aktif
     *
     * @return EmailSubscribe
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
     * @return EmailSubscribe
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
     * @return EmailSubscribe
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
     * @return EmailSubscribe
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
     * @return EmailSubscribe
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
     * Add artikelEmail
     *
     * @param \AppBundle\Entity\ArtikelEmail $artikelEmail
     *
     * @return EmailSubscribe
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
}
