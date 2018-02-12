<?php

namespace AppBundle\Controller\Front;

use AppBundle\Manager\DealerManager;
use AppBundle\Manager\PropinsiManager;
use AppBundle\Manager\SettingManager;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DealerController
 *
 * @package AppBundle\Controller\Front
 *
 * @Route(path="/dealer", name="app_dealer")
 */
class DealerController extends Controller
{
    /**
     * @var Serializer
     * @Inject("serializer")
     */
    private $serializer;

    /**
     * @var SettingManager
     * @Inject("manager.setting")
     */
    private $settingManager;

    /**
     * @var DealerManager
     * @Inject("manager.dealer")
     */
    private $dealerManager;

    /**
     * @var PropinsiManager
     * @Inject("manager.propinsi")
     */
    private $propinsiManager;

    /**
     * @Route(path="/", name="app_dealer_index")
     */
    public function indexAction(Request $request)
    {
        $dealer    = $this->settingManager->getDealerSetting();
        $propinsis = $this->propinsiManager->findAllAktif();

        return $this->render('AppBundle:Front/Dealer:index.html.twig', [
            'dealer'    => $dealer,
            'propinsis' => $propinsis
        ]);
    }

    /**
     * @Route("/get-dropdown-aktif", name="app_dealer_get_dropdown_aktif")
     */
    public function getDropdownAktifAction(Request $request)
    {
        $dealers = $this->dealerManager->findAllAktif();

        return new Response($this->serializer->serialize($dealers, 'json',
            SerializationContext::create()->setGroups(['dropdown'])->enableMaxDepthChecks()));
    }
}
