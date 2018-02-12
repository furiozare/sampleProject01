<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Timestampable;
use JMS\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Kontak
 *
 * @ORM\Table(name="kontak")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\KontakRepository")
 */
class Kontak
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @Groups(groups={"kontak"})
     */
    private $id;

    /**
     * @ORM\Column(name="nama_lengkap", type="string", length=150, nullable=false)
     *
     * @NotBlank()
     *
     * @Groups(groups={"kontak"})
     */
    private $namaLengkap;

    /**
     * @ORM\Column(name="email", type="string", length=150, nullable=false)
     *
     * @NotBlank()
     * @Email()
     *
     * @Groups(groups={"kontak"})
     */
    private $email;

    /**
     * @ORM\Column(name="subyek", type="string", length=200, nullable=false)
     *
     * @NotBlank()
     *
     * @Groups(groups={"kontak"})
     */
    private $subyek;

    /**
     * @ORM\Column(name="pesan", type="text", nullable=false)
     *
     * @NotBlank()
     *
     * @Groups(groups={"kontak"})
     */
    private $pesan;

    /**
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     * @Timestampable(on="create")
     *
     * @Groups(groups={"kontak"})
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
     */
    private $editedBy;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id", nullable=true)
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
     * Set namaLengkap
     *
     * @param string $namaLengkap
     *
     * @return Kontak
     */
    public function setNamaLengkap($namaLengkap)
    {
        $this->namaLengkap = $namaLengkap;

        return $this;
    }

    /**
     * Get namaLengkap
     *
     * @return string
     */
    public function getNamaLengkap()
    {
        return $this->namaLengkap;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Kontak
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
     * Set subyek
     *
     * @param string $subyek
     *
     * @return Kontak
     */
    public function setSubyek($subyek)
    {
        $this->subyek = $subyek;

        return $this;
    }

    /**
     * Get subyek
     *
     * @return string
     */
    public function getSubyek()
    {
        return $this->subyek;
    }

    /**
     * Set pesan
     *
     * @param string $pesan
     *
     * @return Kontak
     */
    public function setPesan($pesan)
    {
        $this->pesan = $pesan;

        return $this;
    }

    /**
     * Get pesan
     *
     * @return string
     */
    public function getPesan()
    {
        return $this->pesan;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Kontak
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
     * @return Kontak
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
     * @return Kontak
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
     * @return Kontak
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
