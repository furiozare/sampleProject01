<?php

namespace AppBundle\Controller\Front;

use AppBundle\Entity\Aksesoris;
use AppBundle\Entity\Kategori;
use AppBundle\Entity\Kendaraan;
use AppBundle\Entity\KendaraanWarna;
use AppBundle\Manager\AksesorisManager;
use AppBundle\Manager\KategoriManager;
use AppBundle\Manager\KendaraanManager;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\Serializer\SerializationContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ProductController
 *
 * @package AppBundle\Controller\Front
 *
 * @Route(path="/product", name="app_product")
 */
class ProductController extends Controller
{
    /**
     * @var KategoriManager
     * @Inject("manager.kategori")
     */
    private $kategoriManager;

    /**
     * @var KendaraanManager
     * @Inject("manager.kendaraan")
     */
    private $kendaraanManager;

    /**
     * @var AksesorisManager
     * @Inject("manager.aksesoris")
     */
    private $aksesorisManager;

    /**
     * @Route(path="/", name="app_product_index")
     */
    public function indexAction(Request $request)
    {
        $kategoris = $this->kategoriManager->findAllAktif();

        return $this->render('AppBundle:Front/Product:index.html.twig', [
            'kategoris' => $kategoris
        ]);
    }

    /**
     * @Route(path="/pesan/{slug}/{slug1}/{warnaId}", name="app_product_booking")
     * @ParamConverter("kendaraan", class="AppBundle:Kendaraan", options={
     *     "mapping": {"slug": "slug", "slug1": "slug1"},
     *     "repository_method" = "findAktifBySlugKategoriAndSlug",
     *     "map_method_signature" = true
     * })
     * @ParamConverter("kendaraanWarna", class="AppBundle:KendaraanWarna", options={
     *     "mapping": {"slug": "slug", "slug1": "slug1", "warnaId": "warnaId"},
     *     "repository_method" = "findAktifBySlugKategoriAndSlugKendaraanAndId",
     *     "map_method_signature" = true
     * })
     */
    public function pesanAction(Kendaraan $kendaraan, KendaraanWarna $kendaraanWarna, Request $request)
    {
        return $this->render('AppBundle:Front/Product:booking.html.twig', [
            'kendaraan'      => $kendaraan,
            'kendaraanWarna' => $kendaraanWarna
        ]);
    }

    /**
     * @Route("/{slug}", name="app_product_kategori")
     * @ParamConverter("kategori", class="AppBundle:Kategori", options={
     *     "mapping": {"slug": "slug"},
     *     "repository_method" = "findAktifBySlug"
     * })
     */
    public function kategoriAction(Kategori $kategori, Request $request)
    {
        $kendaraans = $this->kendaraanManager->findAllAktifByKategoriId($kategori->getId());

        return $this->render('AppBundle:Front/Product:kategori.html.twig', [
            'kendaraans' => $kendaraans,
            'kategori'   => $kategori
        ]);
    }

    /**
     * @Route("/{slug}/{slug1}", name="app_product_detail_kendaraan")
     * @ParamConverter("kendaraan", class="AppBundle:Kendaraan", options={
     *     "mapping": {"slug": "slug", "slug1": "slug1"},
     *     "repository_method" = "findAktifBySlugKategoriAndSlug",
     *     "map_method_signature" = true
     * })
     */
    public function detailKendaraanAction(Kendaraan $kendaraan, Request $request)
    {
        $kendaraanPhotos = $kendaraan->getKendaraanPhotos();
        $kendaraanWarnas = $kendaraan->getKendaraanWarnas();
        $aksesorises     = $this->aksesorisManager->findAllAktifByKendaraanId($kendaraan->getId());

        return $this->render('AppBundle:Front/Product:detail.html.twig', [
            'kendaraan'       => $kendaraan,
            'aksesorises'     => $aksesorises,
            'kendaraanPhotos' => $this->get('serializer')->serialize($kendaraanPhotos, 'json',
                SerializationContext::create()->setGroups(['kendaraanPhoto'])->enableMaxDepthChecks()),
            'kendaraanWarnas' => $this->get('serializer')->serialize($kendaraanWarnas, 'json',
                SerializationContext::create()->setGroups(['kendaraanWarna'])->enableMaxDepthChecks()),
        ]);
    }

    /**
     * @Route("/{slug}/{slug1}/{slug2}", name="app_product_detail_aksesoris")
     * @ParamConverter("aksesoris", class="AppBundle:Aksesoris", options={
     *     "mapping": {"slug": "slug", "slug1": "slug1", "slug2": "slug2"},
     *     "repository_method" = "findAktifBySlugKategoriAndSlugKendaraanAndSlug",
     *     "map_method_signature" = true
     * })
     */
    public function detailAksesorisAction(Aksesoris $aksesoris, Request $request)
    {
        $aksesorisPhotos  = $aksesoris->getAksesorisPhotos();
        $aksesorisDetails = $aksesoris->getAksesorisDetails();

        return $this->render('AppBundle:Front/Product:detailAksesoris.html.twig', [
            'aksesoris'        => $aksesoris,
            'aksesorisPhotos'  => $this->get('serializer')->serialize($aksesorisPhotos, 'json',
                SerializationContext::create()->setGroups(['aksesorisFront'])->enableMaxDepthChecks()),
            'aksesorisDetails' => $this->get('serializer')->serialize($aksesorisDetails, 'json',
                SerializationContext::create()->setGroups(['aksesorisFront'])->enableMaxDepthChecks()),
        ]);
    }

    public function listKategoriAction($currentPath, $currentUrl, Request $request)
    {
        $kategoris = $this->kategoriManager->findAllAktif();

        return $this->render('AppBundle:Front/Product:listKategori.html.twig', [
            'currentPath' => $currentPath,
            'currentUrl'  => $currentUrl,
            'kategoris'   => $kategoris
        ]);
    }
}
