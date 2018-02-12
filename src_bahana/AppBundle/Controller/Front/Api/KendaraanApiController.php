<?php

namespace AppBundle\Controller\Front\Api;

use AppBundle\Manager\KendaraanManager;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class KendaraanApiController
 *
 * @package AppBundle\Controller\Front
 *
 * @Route(path="/api/kendaraan", name="app_api_kendaraan")
 */
class KendaraanApiController extends Controller
{
    /**
     * @var Serializer
     * @Inject("serializer")
     */
    private $serializer;

    /**
     * @var KendaraanManager
     * @Inject("manager.kendaraan")
     */
    private $kendaraanManager;

    /**
     * @Route("/get-dropdown-aktif", name="app_api_kendaraan_get_dropdown_aktif")
     */
    public function getDropdownAktifAction(Request $request)
    {
        $kendaraans = $this->kendaraanManager->findAllAktif();

        return new Response($this->serializer->serialize($kendaraans, 'json',
            SerializationContext::create()->setGroups(['dropdown'])->enableMaxDepthChecks()));
    }
}
