<?php

namespace AppBundle\Controller\Front\Api;

use AppBundle\Entity\Kendaraan;
use AppBundle\Manager\HargaOTRManager;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator;

/**
 * @Route("/api/harga-otr", name="app_front_api_harga_otr")
 */
class HargaOTRApiController extends Controller
{
    /**
     * @var Serializer
     * @Inject("serializer")
     */
    private $serializer;

    /**
     * @var HargaOTRManager
     * @Inject("manager.hargaOTR")
     */
    private $hargaOTRManager;

    /**
     * @Route("/kendaraan/{id}", name="app_front_api_harga_otr_get_kendaraan", methods={"GET"})
     * @ParamConverter("kendaraan", class="AppBundle:Kendaraan", options={"mapping": {"id": "id"}})
     */
    public function getKendaraanAction(Kendaraan $kendaraan, Request $request)
    {
        $hargaOTRs = $this->hargaOTRManager->findAllByKendaraanId($kendaraan->getId());

        return new Response($this->serializer->serialize($hargaOTRs, 'json',
            SerializationContext::create()->setGroups(['bookingKendaraan'])->enableMaxDepthChecks()));
    }

    /**
     * @Route("/kendaraan-slug/{slug}/{slug1}", name="app_front_api_harga_otr_get_kendaraan_slug", methods={"GET"})
     * @ParamConverter("kendaraan", class="AppBundle:Kendaraan", options={
     *     "mapping": {"slug": "slug", "slug1": "slug1"},
     *     "repository_method" = "findAktifBySlugKategoriAndSlug",
     *     "map_method_signature" = true
     * })
     */
    public function getKendaraanSlugAction(Kendaraan $kendaraan, Request $request)
    {
        $hargaOTRs = $this->hargaOTRManager->findAllByKendaraanId($kendaraan->getId());

        return new Response($this->serializer->serialize($hargaOTRs, 'json',
            SerializationContext::create()->setGroups(['bookingKendaraan'])->enableMaxDepthChecks()));
    }
}
