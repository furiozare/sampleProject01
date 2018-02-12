<?php

namespace AppBundle\Controller\Secured;

use AppBundle\Manager\EmailSubscribeManager;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/email-subscribe", name="app_secured_email_subscribe")
 */
class EmailSubscribeController extends Controller
{
    /**
     * @var Serializer
     * @Inject("serializer")
     */
    private $serializer;

    /**
     * @var EmailSubscribeManager
     * @Inject("manager.emailSubscribe")
     */
    private $emailSubscribeManager;

    /**
     * @Route("", name="app_secured_email_subscribe_index", methods={"GET"})
     */
    public function indexAction(Request $request)
    {
        return $this->render('AppBundle:Secured/EmailSubscribe:index.html.twig', []);
    }
}
