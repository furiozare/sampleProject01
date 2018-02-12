<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Blameable;
use Gedmo\Mapping\Annotation\Timestampable;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\MaxDepth;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * BookingOrder
 *
 * @ORM\Table(name="booking_order")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BookingOrderRepository")
 */
class BookingOrder
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @Groups(groups={"bookingOrder"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nama_lengkap", type="string", length=150, nullable=false)
     *
     * @NotBlank()
     *
     * @Groups(groups={"bookingOrder"})
     */
    private $namaLengkap;

    /**
     * @var string
     *
     * @ORM\Column(name="tanggal_lahir", type="date", nullable=false)
     *
     * @NotBlank()
     * @Date()
     *
     * @Groups(groups={"bookingOrder"})
     */
    private $tanggalLahir;

    /**
     * @var string
     *
     * @ORM\Column(name="tempat_lahir", type="string", length=150, nullable=false)
     *
     * @NotBlank()
     *
     * @Groups(groups={"bookingOrder"})
     */
    private $tempatLahir;

    /**
     * @var string
     *
     * @ORM\Column(name="no_ktp", type="string", length=150, nullable=false)
     *
     * @NotBlank()
     *
     * @Groups(groups={"bookingOrder"})
     */
    private $noKTP;

    /**
     * @var string
     *
     * @ORM\Column(name="no_npwp", type="string", length=150, nullable=false)
     *
     * @NotBlank()
     *
     * @Groups(groups={"bookingOrder"})
     */
    private $noNPWP;

    /**
     * @var string
     *
     * @ORM\Column(name="alamat", type="text", nullable=true)
     *
     * @NotBlank()
     *
     * @Groups(groups={"bookingOrder"})
     */
    private $alamat;

    /**
     * @var string
     *
     * @ORM\Column(name="kota", type="string", length=150, nullable=true)
     *
     * @NotBlank()
     *
     * @Groups(groups={"bookingOrder"})
     */
    private $kota;

    /**
     * @var string
     *
     * @ORM\Column(name="kode_pos", type="string", length=150, nullable=true)
     *
     * @NotBlank()
     *
     * @Groups(groups={"bookingOrder"})
     */
    private $kodePos;

    /**
     * @var string
     *
     * @ORM\Column(name="kecamatan", type="string", length=150, nullable=true)
     *
     * @NotBlank()
     *
     * @Groups(groups={"bookingOrder"})
     */
    private $kecamatan;

    /**
     * @var string
     *
     * @ORM\Column(name="kelurahan", type="string", length=150, nullable=true)
     *
     * @NotBlank()
     *
     * @Groups(groups={"bookingOrder"})
     */
    private $kelurahan;

    /**
     * @var string
     *
     * @ORM\Column(name="telepon", type="string", length=100, nullable=true)
     *
     * @NotBlank()
     *
     * @Groups(groups={"bookingOrder"})
     */
    private $telepon;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=150, nullable=false)
     *
     * @NotBlank()
     * @Email()
     *
     * @Groups(groups={"bookingOrder"})
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="jenis_kelamin", type="smallint", nullable=false)
     *
     * @NotBlank()
     *
     * @Groups(groups={"bookingOrder"})
     */
    private $jenisKelamin;

    /**
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     * @Timestampable(on="create")
     *
     * @Groups(groups={"bookingOrder"})
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\KendaraanWarna")
     * @ORM\JoinColumn(name="kendaraan_warna_id", referencedColumnName="id", nullable=true)
     *
     * @Groups(groups={"bookingOrder"})
     * @MaxDepth(depth=3)
     */
    private $kendaraanWarna;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Dealer")
     * @ORM\JoinColumn(name="dealer_id", referencedColumnName="id", nullable=true)
     *
     * @NotBlank()
     *
     * @Groups(groups={"bookingOrder"})
     * @MaxDepth(depth=2)
     */
    private $dealer;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\HargaOTR")
     * @ORM\JoinColumn(name="harga_otr_id", referencedColumnName="id", nullable=true)
     *
     * @NotBlank()
     *
     * @Groups(groups={"bookingOrder"})
     * @MaxDepth(depth=2)
     */
    private $hargaOTR;

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
     * @return BookingOrder
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
     * Set tanggalLahir
     *
     * @param \DateTime $tanggalLahir
     *
     * @return BookingOrder
     */
    public function setTanggalLahir($tanggalLahir)
    {
        $this->tanggalLahir = $tanggalLahir;

        return $this;
    }

    /**
     * Get tanggalLahir
     *
     * @return \DateTime
     */
    public function getTanggalLahir()
    {
        return $this->tanggalLahir;
    }

    /**
     * Set tempatLahir
     *
     * @param string $tempatLahir
     *
     * @return BookingOrder
     */
    public function setTempatLahir($tempatLahir)
    {
        $this->tempatLahir = $tempatLahir;

        return $this;
    }

    /**
     * Get tempatLahir
     *
     * @return string
     */
    public function getTempatLahir()
    {
        return $this->tempatLahir;
    }

    /**
     * Set noKTP
     *
     * @param string $noKTP
     *
     * @return BookingOrder
     */
    public function setNoKTP($noKTP)
    {
        $this->noKTP = $noKTP;

        return $this;
    }

    /**
     * Get noKTP
     *
     * @return string
     */
    public function getNoKTP()
    {
        return $this->noKTP;
    }

    /**
     * Set noNPWP
     *
     * @param string $noNPWP
     *
     * @return BookingOrder
     */
    public function setNoNPWP($noNPWP)
    {
        $this->noNPWP = $noNPWP;

        return $this;
    }

    /**
     * Get noNPWP
     *
     * @return string
     */
    public function getNoNPWP()
    {
        return $this->noNPWP;
    }

    /**
     * Set alamat
     *
     * @param string $alamat
     *
     * @return BookingOrder
     */
    public function setAlamat($alamat)
    {
        $this->alamat = $alamat;

        return $this;
    }

    /**
     * Get alamat
     *
     * @return string
     */
    public function getAlamat()
    {
        return $this->alamat;
    }

    /**
     * Set kota
     *
     * @param string $kota
     *
     * @return BookingOrder
     */
    public function setKota($kota)
    {
        $this->kota = $kota;

        return $this;
    }

    /**
     * Get kota
     *
     * @return string
     */
    public function getKota()
    {
        return $this->kota;
    }

    /**
     * Set kodePos
     *
     * @param string $kodePos
     *
     * @return BookingOrder
     */
    public function setKodePos($kodePos)
    {
        $this->kodePos = $kodePos;

        return $this;
    }

    /**
     * Get kodePos
     *
     * @return string
     */
    public function getKodePos()
    {
        return $this->kodePos;
    }

    /**
     * Set kecamatan
     *
     * @param string $kecamatan
     *
     * @return BookingOrder
     */
    public function setKecamatan($kecamatan)
    {
        $this->kecamatan = $kecamatan;

        return $this;
    }

    /**
     * Get kecamatan
     *
     * @return string
     */
    public function getKecamatan()
    {
        return $this->kecamatan;
    }

    /**
     * Set kelurahan
     *
     * @param string $kelurahan
     *
     * @return BookingOrder
     */
    public function setKelurahan($kelurahan)
    {
        $this->kelurahan = $kelurahan;

        return $this;
    }

    /**
     * Get kelurahan
     *
     * @return string
     */
    public function getKelurahan()
    {
        return $this->kelurahan;
    }

    /**
     * Set telepon
     *
     * @param string $telepon
     *
     * @return BookingOrder
     */
    public function setTelepon($telepon)
    {
        $this->telepon = $telepon;

        return $this;
    }

    /**
     * Get telepon
     *
     * @return string
     */
    public function getTelepon()
    {
        return $this->telepon;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return BookingOrder
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return BookingOrder
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
     * @return BookingOrder
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
     * @return BookingOrder
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
     * @return BookingOrder
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
     * Set kendaraanWarna
     *
     * @param \AppBundle\Entity\KendaraanWarna $kendaraanWarna
     *
     * @return BookingOrder
     */
    public function setKendaraanWarna(\AppBundle\Entity\KendaraanWarna $kendaraanWarna = null)
    {
        $this->kendaraanWarna = $kendaraanWarna;

        return $this;
    }

    /**
     * Get kendaraanWarna
     *
     * @return \AppBundle\Entity\KendaraanWarna
     */
    public function getKendaraanWarna()
    {
        return $this->kendaraanWarna;
    }

    /**
     * Set dealer
     *
     * @param \AppBundle\Entity\Dealer $dealer
     *
     * @return BookingOrder
     */
    public function setDealer(\AppBundle\Entity\Dealer $dealer = null)
    {
        $this->dealer = $dealer;

        return $this;
    }

    /**
     * Get dealer
     *
     * @return \AppBundle\Entity\Dealer
     */
    public function getDealer()
    {
        return $this->dealer;
    }

    /**
     * Set jenisKelamin
     *
     * @param integer $jenisKelamin
     *
     * @return BookingOrder
     */
    public function setJenisKelamin($jenisKelamin)
    {
        $this->jenisKelamin = $jenisKelamin;

        return $this;
    }

    /**
     * Get jenisKelamin
     *
     * @return integer
     */
    public function getJenisKelamin()
    {
        return $this->jenisKelamin;
    }

    /**
     * Set hargaOTR
     *
     * @param \AppBundle\Entity\HargaOTR $hargaOTR
     *
     * @return BookingOrder
     */
    public function setHargaOTR(\AppBundle\Entity\HargaOTR $hargaOTR = null)
    {
        $this->hargaOTR = $hargaOTR;

        return $this;
    }

    /**
     * Get hargaOTR
     *
     * @return \AppBundle\Entity\HargaOTR
     */
    public function getHargaOTR()
    {
        return $this->hargaOTR;
    }
}
