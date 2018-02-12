<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * DetailKendaraan
 *
 * @ORM\Table(name="detail_kendaraan")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DetailKendaraanRepository")
 */
class DetailKendaraan
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
     * @var boolean
     *
     * @ORM\Column(name="aktif", type="boolean", nullable=false)
     */
    private $aktif = true;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Warna")
     * @ORM\JoinColumn(name="warna_id", referencedColumnName="id", nullable=false)
     *
     * @NotBlank()
     */
    private $warna;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Kendaraan")
     * @ORM\JoinColumn(name="kendaraan_id", referencedColumnName="id", nullable=false)
     *
     * @NotBlank()
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
     * Set aktif
     *
     * @param boolean $aktif
     *
     * @return DetailKendaraan
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
     * Set warna
     *
     * @param \AppBundle\Entity\Warna $warna
     *
     * @return DetailKendaraan
     */
    public function setWarna(\AppBundle\Entity\Warna $warna)
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
     * @return DetailKendaraan
     */
    public function setKendaraan(\AppBundle\Entity\Kendaraan $kendaraan)
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
}
