<?php

namespace AppBundle\Controller\Secured\Api;

use AppBundle\Manager\BookingServiceManager;
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
 * @Route("/api/booking-service", name="app_secured_api_booking_service")
 */
class BookingServiceApiController extends Controller
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
     * @var BookingServiceManager
     * @Inject("manager.bookingService")
     */
    private $bookingServiceManager;

    /**
     * @var DealerManager
     * @Inject("manager.dealer")
     */
    private $dealerManager;

    /**
     * @Route("", name="app_secured_api_booking_service_get", methods={"GET"})
     */
    public function getAction(Request $request)
    {
        $bookingServices = $this->bookingServiceManager->findAll();

        return new Response($this->serializer->serialize($bookingServices, 'json',
            SerializationContext::create()->setGroups(['service'])->enableMaxDepthChecks()));
    }

    /**
     * @Route("/get-booking-service", name="app_secured_api_booking_service_get_booking_service", methods={"POST"})
     */
    public function getBookingServiceAction(Request $request)
    {
        $response = [
            'result'          => 'error',
            'errors'          => [],
            'bookingServices' => []
        ];

        $params = $request->request->all();
        if ($params['startDate'] == "Invalid date") {
            $params['startDate'] = '2016-01-01';
        }
        if ($params['endDate'] == "Invalid date") {
            $params['endDate'] = '2020-01-01';
        }

        $bookingServices = $this->bookingServiceManager->findAllByDateRangeAndDealer($params['startDate'], $params['endDate'], $params['dealer']);

        $response['bookingServices'] = json_decode($this->serializer->serialize($bookingServices, 'json',
            SerializationContext::create()->setGroups(['service'])->enableMaxDepthChecks()));;
        $response['result'] = 'success';

        return (new JsonResponse($response))->setEncodingOptions(JSON_NUMERIC_CHECK);
    }
}
