<?php

namespace AppBundle\Controller\Secured\Api;

use AppBundle\Manager\BookingOrderManager;
use AppBundle\Manager\DealerManager;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator;

/**
 * @Route("/api/booking-order", name="app_secured_api_booking_order")
 */
class BookingOrderApiController extends Controller
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
     * @var DealerManager
     * @Inject("manager.dealer")
     */
    private $dealerManager;

    /**
     * @Route("", name="app_secured_api_booking_order_get", methods={"GET"})
     */
    public function getAction(Request $request)
    {
        $bookingOrders = $this->bookingOrderManager->findAll();

        return new Response($this->serializer->serialize($bookingOrders, 'json',
            SerializationContext::create()->setGroups(['bookingOrder'])->enableMaxDepthChecks()));
    }

    /**
     * @Route("/get-booking-order", name="app_secured_api_booking_order_get_booking_order", methods={"POST"})
     */
    public function getBookingOrderAction(Request $request)
    {
        $response = [
            'result'          => 'error',
            'errors'          => [],
            'bookingOrders' => []
        ];

        $params = $request->request->all();
        if ($params['startDate'] == "Invalid date") {
            $params['startDate'] = '2016-01-01';
        }
        if ($params['endDate'] == "Invalid date") {
            $params['endDate'] = '2020-01-01';
        }

        $bookingOrders = $this->bookingOrderManager->findAllByDateRangeAndKendaraan($params['startDate'], $params['endDate'], $params['kendaraan']);

        $response['bookingOrders'] = json_decode($this->serializer->serialize($bookingOrders, 'json',
            SerializationContext::create()->setGroups(['bookingOrder'])->enableMaxDepthChecks()));;
        $response['result'] = 'success';

        return (new JsonResponse($response))->setEncodingOptions(JSON_NUMERIC_CHECK);
    }
}
