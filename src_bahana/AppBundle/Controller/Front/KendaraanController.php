<?php

namespace AppBundle\Controller\Front;

use AppBundle\Manager\KendaraanManager;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class KendaraanController
 *
 * @package AppBundle\Controller\Front
 *
 * @Route(path="/kendaraan", name="app_kendaraan")
 */
class KendaraanController extends Controller
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
     * @Route("/get-dropdown-aktif", name="app_kendaraan_get_dropdown_aktif")
     */
    public function getDropdownAktifAction(Request $request)
    {
        $kendaraans = $this->kendaraanManager->findAllAktif();

        return new Response($this->serializer->serialize($kendaraans, 'json',
            SerializationContext::create()->setGroups(['dropdown'])->enableMaxDepthChecks()));
    }
}
