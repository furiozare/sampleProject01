<?php

namespace AppBundle\Controller\Front\Api;

use AppBundle\Manager\DealerManager;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DealerApiController
 *
 * @package AppBundle\Controller\Front\Api
 *
 * @Route(path="/api/dealer", name="app_api_dealer")
 */
class DealerApiController extends Controller
{
    /**
     * @var Serializer
     * @Inject("serializer")
     */
    private $serializer;

    /**
     * @var DealerManager
     * @Inject("manager.dealer")
     */
    private $dealerManager;

    /**
     * @Route("/get-dropdown-aktif", name="app_api_dealer_get_dropdown_aktif")
     */
    public function getDropdownAktifAction(Request $request)
    {
        $dealers = $this->dealerManager->findAllAktif();

        return new Response($this->serializer->serialize($dealers, 'json',
            SerializationContext::create()->setGroups(['dropdown'])->enableMaxDepthChecks()));
    }
}
