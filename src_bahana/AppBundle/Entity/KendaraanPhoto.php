<?php

namespace AppBundle\Entity;

use AppBundle\Lib\FileUploadLib;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Blameable;
use Gedmo\Mapping\Annotation\Timestampable;
use Gedmo\Mapping\Annotation\Uploadable;
use Gedmo\Mapping\Annotation\UploadableFileName;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * KendaraanPhoto
 *
 * @ORM\Table(name="kendaraan_photo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\KendaraanPhotoRepository")
 * @Uploadable(pathMethod="getPath", filenameGenerator="SHA1", allowOverwrite=true, appendNumber=true)
 */
class KendaraanPhoto
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @Groups(groups={"kendaraanPhoto", "dropdown"})
     */
    private $id;

    /**
     * @ORM\Column(name="foto", type="string", length=255, nullable=true)
     * @UploadableFileName()
     */
    private $foto;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Kendaraan")
     * @ORM\JoinColumn(name="kendaraan_id", referencedColumnName="id", nullable=true)
     *
     * @NotBlank()
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
     * @var UploadedFile
     * @NotBlank(groups={"create"})
     * @Image()
     */
    private $file;

    /**
     * @VirtualProperty()
     * @Groups({"kendaraanPhoto"})
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
        return 'img/kendaraan';
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
     * @return KendaraanPhoto
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return KendaraanPhoto
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
     * @return KendaraanPhoto
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
     * Set kendaraan
     *
     * @param \AppBundle\Entity\Kendaraan $kendaraan
     *
     * @return KendaraanPhoto
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
     * @return KendaraanPhoto
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
     * @return KendaraanPhoto
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
