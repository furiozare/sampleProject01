<?php

namespace AppBundle\Controller\Front;

use AppBundle\Entity\Artikel;
use AppBundle\Entity\KategoriNews;
use AppBundle\Manager\ArtikelManager;
use AppBundle\Manager\KategoriNewsManager;
use AppBundle\Manager\SettingManager;
use JMS\DiExtraBundle\Annotation\Inject;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ArticleController
 *
 * @package AppBundle\Controller\Front
 *
 * @Route(path="/article", name="app_article")
 */
class ArticleController extends Controller
{
    /**
     * @var SettingManager
     * @Inject("manager.setting")
     */
    private $settingManager;

    /**
     * @var KategoriNewsManager
     * @Inject("manager.kategoriNews")
     */
    private $kategoriNewsManager;

    /**
     * @var ArtikelManager
     * @Inject("manager.artikel")
     */
    private $artikelManager;

    /**
     * @Route(path="/construction-page", name="app_article_construction")
     */
    public function constructionAction(Request $request)
    {
        return $this->render('AppBundle:Front/Article:construction.html.twig');
    }

    /**
     * @Route("/{slug}", name="app_article_kategori_news")
     * @Extra\ParamConverter("kategoriNews", class="AppBundle:KategoriNews", options={
     *     "mapping": {"slug": "slug"},
     *     "repository_method" = "findAktifBySlug",
     *     "map_method_signature" = true
     * })
     */
    public function kategoriAction(KategoriNews $kategoriNews, Request $request)
    {
        $articles = $this->artikelManager->findAllAktifByKategoriNewsId($kategoriNews->getId());

        return $this->render('AppBundle:Front/Article:kategori.html.twig', [
            'articles'     => $articles,
            'kategoriNews' => $kategoriNews
        ]);
    }

    public function listKategoriAction($currentPath, $currentUrl, Request $request)
    {
        $kategoriNewss = $this->kategoriNewsManager->findAllAktif();

        return $this->render('AppBundle:Front/Article:listKategori.html.twig', [
            'currentPath'   => $currentPath,
            'currentUrl'    => $currentUrl,
            'kategoriNewss' => $kategoriNewss
        ]);
    }

    /**
     * @Route(path="/{slugKategori}/{slugArtikel}", name="app_article_detail")
     * @Extra\ParamConverter("artikel", class="AppBundle:Artikel", options={
     *     "mapping": {"slugKategori": "slugKategori", "slugArtikel": "slugArtikel"},
     *     "repository_method" = "findAktifBySlugKategoriAndSlug",
     *     "map_method_signature" = true
     * })
     */
    public function detailAction(Artikel $artikel, Request $request)
    {
        return $this->render('AppBundle:Front/Article:detail.html.twig', [
            "artikel" => $artikel
        ]);
    }
}
