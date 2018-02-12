<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Artikel;
use AppBundle\Entity\KategoriNews;
use AppBundle\Repository\ArtikelRepository;
use AppBundle\Repository\KategoriNewsRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\DiExtraBundle\Annotation\InjectParams;
use JMS\DiExtraBundle\Annotation\Service;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Service(id="manager.artikel")
 */
class ArtikelManager
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var ArtikelRepository
     */
    private $artikelRepository;

    /**
     * @var KategoriNewsRepository
     */
    private $kategoriNewsRepository;

    /**
     * @InjectParams({
     *      "entityManager" = @Inject("doctrine.orm.default_entity_manager")
     * })
     */
    function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

        $this->artikelRepository      = $this->entityManager->getRepository("AppBundle:Artikel");
        $this->kategoriNewsRepository = $this->entityManager->getRepository("AppBundle:KategoriNews");
    }

    public function assignRequest(Artikel $artikel, Request $request)
    {
        if (!is_null($request->files->get('file'))) {
            $artikel->setFile($request->files->get('file'));
        } else {
            $artikel->setFile(null);
        }
        if (!is_null($request->request->get('judul'))) {
            $judul = trim($request->request->get('judul'));
            if ($judul != "") {
                $artikel->setJudul($request->request->get('judul'));
            } else {
                $artikel->setJudul(null);
            }
        }
        if (!is_null($request->request->get('isi'))) {
            $isi = trim($request->request->get('isi'));
            if ($isi != "") {
                $artikel->setIsi($request->request->get('isi'));
            } else {
                $artikel->setIsi(null);
            }
        }
        if (!is_null($request->request->get('caption'))) {
            $caption = trim($request->request->get('caption'));
            if ($caption != "") {
                $artikel->setCaption($request->request->get('caption'));
            } else {
                $artikel->setCaption(null);
            }
        }
        if (!is_null($request->request->get('sumber'))) {
            $sumber = trim($request->request->get('sumber'));
            if ($sumber != "") {
                $artikel->setSumber($request->request->get('sumber'));
            } else {
                $artikel->setSumber(null);
            }
        }
        if (is_null($request->request->get('aktif'))) {
            $artikel->setAktif(false);
        } else {
            $artikel->setAktif($request->request->get('aktif') == "true");
        }
        if (!is_null($request->request->get('kategori_news'))) {
            $kategori_news = $this->kategoriNewsRepository->queryById($request->request->get('kategori_news'))->getQuery()->getOneOrNullResult();
            if ($kategori_news instanceof KategoriNews) {
                $artikel->setKategoriNews($kategori_news);
            } else {
                $artikel->setKategoriNews();
            }
        }
    }

    public function findAllAktif()
    {
        $query = $this->artikelRepository->queryAktif()->getQuery();

        return $query->getResult();
    }

    public function findAllAktifByKategoriNewsId($kategoriNewsId)
    {
        $query = $this->artikelRepository->queryAktif();
        $query = $this->artikelRepository->queryByKategoriId($kategoriNewsId, $query);

        return $query->getQuery()->getResult();
    }

    public function findAllMarkForBlast()
    {
        $query = $this->artikelRepository->queryAktif();
        $query = $this->artikelRepository->queryMarkForBlast($query);
        $query = $this->artikelRepository->queryOrderByTanggal(Criteria::ASC, $query);

        return $query->getQuery()->getResult();
    }

    public function findAll()
    {
        $query = $this->artikelRepository->query()->getQuery();

        return $query->getResult();
    }

    public function findOneById($id)
    {
        $query = $this->artikelRepository->queryById($id)->getQuery();

        return $query->getOneOrNullResult();
    }

    public function remove(Artikel $artikel)
    {
        $this->entityManager->remove($artikel);
        $this->entityManager->flush();
    }

    public function save(Artikel $artikel)
    {
        if (!$artikel->getId()) {
            $this->entityManager->persist($artikel);
        }
        $this->entityManager->flush();
    }
}
