<?php

namespace AppBundle\Controller\Secured;

use AppBundle\Manager\BookingOrderManager;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\Serializer\Serializer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator;

/**
 * @Route("/booking-order", name="app_secured_booking_order")
 */
class BookingOrderController extends Controller
{
    /**
     * @var Validator
     * @Inject("validator")
     */
    private $validator;

    /**
     * @var Serializer
     * @Inject("serializer")
     */
    private $serializer;

    /**
     * @var BookingOrderManager
     * @Inject("manager.bookingOrder")
     */
    private $bookingOrderManager;

    /**
     * @Route("/", name="app_secured_booking_order_index", methods={"GET"})
     */
    public function indexAction(Request $request)
    {
        return $this->render('AppBundle:Secured/BookingOrder:index.html.twig', []);
    }
}
