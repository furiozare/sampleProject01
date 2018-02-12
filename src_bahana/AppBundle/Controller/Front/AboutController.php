<?php

namespace AppBundle\Controller\Front;

use AppBundle\Manager\SettingManager;
use JMS\DiExtraBundle\Annotation\Inject;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AboutController
 *
 * @package AppBundle\Controller\Front
 *
 * @Route(path="/about", name="app_about")
 */
class AboutController extends Controller
{
    /**
     * @var SettingManager
     * @Inject("manager.setting")
     */
    private $settingManager;

    /**
     * @Route(path="/", name="app_about_index")
     */
    public function indexAction(Request $request)
    {
        $about = $this->settingManager->getTentangSetting();

        return $this->render('AppBundle:Front/About:index.html.twig', [
            'about' => $about
        ]);
    }
}
