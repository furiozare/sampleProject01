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
 * PartPhoto
 *
 * @ORM\Table(name="part_photo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PartPhotoRepository")
 * @Uploadable(pathMethod="getPath", filenameGenerator="SHA1", allowOverwrite=true, appendNumber=true)
 */
class PartPhoto
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @Groups(groups={"partPhoto", "dropdown", "partFront"})
     */
    private $id;

    /**
     * @ORM\Column(name="foto", type="string", length=255, nullable=true)
     * @UploadableFileName()
     */
    private $foto;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Part", inversedBy="partPhotos")
     * @ORM\JoinColumn(name="part_id", referencedColumnName="id", nullable=true)
     *
     * @NotBlank()
     */
    private $part;

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
     * @Groups({"partPhoto", "partFront"})
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
        return 'img/part-photo';
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
     * @return PartPhoto
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
     * @return PartPhoto
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
     * @return PartPhoto
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
     * Set part
     *
     * @param \AppBundle\Entity\Part $part
     *
     * @return PartPhoto
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
     * Set editedBy
     *
     * @param \AppBundle\Entity\User $editedBy
     *
     * @return PartPhoto
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
     * @return PartPhoto
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
