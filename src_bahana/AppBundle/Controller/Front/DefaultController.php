<?php

namespace AppBundle\Controller\Front;

use AppBundle\Entity\TImage;
use AppBundle\Entity\TRole;
use AppBundle\Entity\TUser;
use AppBundle\Manager\HeadlineManager;
use AppBundle\Manager\TImageManager;
use AppBundle\Manager\TRoleManager;
use AppBundle\Manager\TUserManager;
use JMS\DiExtraBundle\Annotation\Inject;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DefaultController
 *
 * @package AppBundle\Controller\Front
 *
 * @Route(path="/", name="app_default")
 */
class DefaultController extends Controller
{
    /**
     * @var HeadlineManager
     * @Inject("manager.headline")
     */
    private $headlineManager;

    /**
     * @Route(path="/", name="app_default_index")
     */
    public function indexAction(Request $request)
    {
        $headlines = $this->headlineManager->findAllAktif();

        return $this->render('AppBundle:Front:Home/index.html.twig', [
            'headlines' => $headlines
        ]);
    }
}
