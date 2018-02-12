<?php

namespace AppBundle\Controller\Secured;

use AppBundle\Manager\BookingKontakManager;
use AppBundle\Manager\KontakManager;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator;

/**
 * @Route("/kontak", name="app_secured_kontak")
 */
class KontakController extends Controller
{
    /**
     * @var Serializer
     * @Inject("serializer")
     */
    private $serializer;

    /**
     * @var KontakManager
     * @Inject("manager.kontak")
     */
    private $kontakManager;

    /**
     * @Route("/", name="app_secured_kontak_index", methods={"GET"})
     */
    public function indexAction(Request $request)
    {
        return $this->render('AppBundle:Secured/Kontak:index.html.twig', []);
    }

    /**
     * @Route("/get", name="app_secured_kontak_get")
     */
    public function getAction(Request $request)
    {
        $bookingKontaks = $this->kontakManager->findAll();

        return new Response($this->serializer->serialize($bookingKontaks, 'json',
            SerializationContext::create()->setGroups(['kontak'])->enableMaxDepthChecks()));
    }
}
