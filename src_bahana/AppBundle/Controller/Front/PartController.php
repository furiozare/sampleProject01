<?php

namespace AppBundle\Controller\Front;

use AppBundle\Entity\KategoriPart;
use AppBundle\Entity\Part;
use AppBundle\Manager\KategoriPartManager;
use AppBundle\Manager\PartManager;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\Serializer\SerializationContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PartController
 *
 * @package AppBundle\Controller\Front
 *
 * @Route(path="/part", name="app_part")
 */
class PartController extends Controller
{
    /**
     * @var KategoriPartManager
     * @Inject("manager.kategoriPart")
     */
    private $kategoriPartManager;

    /**
     * @var PartManager
     * @Inject("manager.part")
     */
    private $partManager;

    /**
     * @Route(path="/", name="app_part_index")
     */
    public function indexAction(Request $request)
    {
        $kategoris = $this->kategoriPartManager->findAllAktif();

        return $this->render('AppBundle:Front/Part:index.html.twig', [
            'kategoris' => $kategoris
        ]);
    }

    /**
     * @Route("/{slug}", name="app_part_kategori")
     * @ParamConverter("kategoriPart", class="AppBundle:KategoriPart", options={
     *     "mapping": {"slug": "slug"},
     *     "repository_method" = "findAktifBySlug"
     * })
     */
    public function kategoriAction(KategoriPart $kategoriPart, Request $request)
    {
        $parts = $this->partManager->findAllAktifByKategoriPartId($kategoriPart->getId());

        return $this->render('AppBundle:Front/Part:kategori.html.twig', [
            'parts'        => $parts,
            'kategoriPart' => $kategoriPart
        ]);
    }

    /**
     * @Route("/{slug}/{slug1}", name="app_part_detail_part")
     * @ParamConverter("part", class="AppBundle:Part", options={
     *     "mapping": {"slug": "slug", "slug1": "slug1"},
     *     "repository_method" = "findAktifBySlugKategoriAndSlug",
     *     "map_method_signature" = true
     * })
     */
    public function detailPartAction(Part $part, Request $request)
    {
        $partPhotos  = $part->getPartPhotos();
        $partUkurans = $part->getPartUkurans();

        return $this->render('AppBundle:Front/Part:detail.html.twig', [
            'part'        => $part,
            'partPhotos'  => $this->get('serializer')->serialize($partPhotos, 'json',
                SerializationContext::create()->setGroups(['partPhoto'])->enableMaxDepthChecks()),
            'partUkurans' => $this->get('serializer')->serialize($partUkurans, 'json',
                SerializationContext::create()->setGroups(['partUkuran'])->enableMaxDepthChecks()),
        ]);
    }

    public function listKategoriAction($currentPath, $currentUrl, Request $request)
    {
        $kategoris = $this->kategoriPartManager->findAllAktif();

        return $this->render('AppBundle:Front/Part:listKategori.html.twig', [
            'currentPath' => $currentPath,
            'currentUrl'  => $currentUrl,
            'kategoris'   => $kategoris
        ]);
    }
}
