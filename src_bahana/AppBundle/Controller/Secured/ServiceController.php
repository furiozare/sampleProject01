<?php

namespace AppBundle\Controller\Secured;

use AppBundle\Manager\BookingServiceManager;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator;

/**
 * @Route("/service", name="app_secured_service")
 */
class ServiceController extends Controller
{
    /**
     * @var Serializer
     * @Inject("serializer")
     */
    private $serializer;

    /**
     * @var BookingServiceManager
     * @Inject("manager.bookingservice")
     */
    private $bookingserviceManager;

    /**
     * @Route("/", name="app_secured_service_index", methods={"GET"})
     */
    public function indexAction(Request $request)
    {
        return $this->render('AppBundle:Secured/Service:index.html.twig', []);
    }

    /**
     * @Route("/get", name="app_secured_service_get")
     */
    public function getAction(Request $request)
    {
        $bookingServices = $this->bookingserviceManager->findAll();

        return new Response($this->serializer->serialize($bookingServices, 'json',
            SerializationContext::create()->setGroups(['service'])->enableMaxDepthChecks()));
    }
}
