<?php

namespace AppBundle\Controller\Front\Api;

use AppBundle\Entity\BookingOrder;
use AppBundle\Entity\KendaraanWarna;
use AppBundle\Manager\BookingOrderManager;
use JMS\DiExtraBundle\Annotation\Inject;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator;

/**
 * @Route("/api/booking-order", name="app_api_bookingOrder")
 */
class BookingOrderApiController extends Controller
{
    /**
     * @var Validator
     * @Inject("validator")
     */
    private $validator;

    /**
     * @var BookingOrderManager
     * @Inject("manager.bookingOrder")
     */
    private $bookingOrderManager;

    /**
     * @Route("/{slug}/{slug1}/{warnaId}", name="app_secured_api_bookingOrder_create", methods={"POST"})
     * @ParamConverter("kendaraanWarna", class="AppBundle:KendaraanWarna", options={
     *     "mapping": {"slug": "slug", "slug1": "slug1", "warnaId": "warnaId"},
     *     "repository_method" = "findAktifBySlugKategoriAndSlugKendaraanAndId",
     *     "map_method_signature" = true
     * })
     */
    public function createAction(KendaraanWarna $kendaraanWarna, Request $request)
    {
        $response = [
            'result' => 'error',
            'errors' => []
        ];

        $bookingOrder = new BookingOrder();
        $bookingOrder->setKendaraanWarna($kendaraanWarna);

        $this->bookingOrderManager->assignRequest($bookingOrder, $request);

        $errorList = $this->validator->validate($bookingOrder, ['create', 'Default']);

        if (count($errorList)) {
            foreach ($errorList as $error) {
                /** @var ConstraintViolation $error */
                $response['errors'][$error->getPropertyPath()] = $error->getMessage();
            }
        } else {
            $this->bookingOrderManager->save($bookingOrder);

            $message = \Swift_Message::newInstance()
                ->setSubject('Booking Kendaraan Berhasil')
                ->setFrom('noreply@bahanayamaha.com')
                ->setTo($bookingOrder->getEmail())
                ->setReplyTo($bookingOrder->getDealer()->getEmailSales())
                ->setBcc('ehs.hantan@gmail.com')
                ->setBody(
                    $this->renderView(
                        'AppBundle:Front/Email:bookingKendaraanEmail.html.twig',
                        [
                            'bookingOrder' => $bookingOrder
                        ]
                    ),
                    'text/html'
                );

            $message->getHeaders()->addIdHeader("Message-ID", time() . "system@bahanayamaha.com");
            $message->getHeaders()->addTextHeader('MIME-Version', '1.0');
            $message->getHeaders()->addTextHeader('X-Mailer', 'PHP v' . phpversion());
            $message->getHeaders()->addParameterizedHeader('Content-type', 'text/html', ['charset' => 'utf-8']);

            $this->get('mailer')->send($message);

            $message = \Swift_Message::newInstance()
                ->setSubject('New Booking Kendaraan')
                ->setFrom('noreply@bahanayamaha.com')
                ->setReplyTo($bookingOrder->getEmail())
                ->setTo($bookingOrder->getDealer()->getEmailSales())
                ->setCc("support@bahanayamaha.com")
                ->setBcc('ehs.hantan@gmail.com')
                ->setBody(
                    $this->renderView(
                        'AppBundle:Front/Email:bookingKendaraanEmail.html.twig',
                        [
                            'bookingOrder' => $bookingOrder
                        ]
                    ),
                    'text/html'
                );

            $message->getHeaders()->addIdHeader("Message-ID", time() . "system@bahanayamaha.com");
            $message->getHeaders()->addTextHeader('MIME-Version', '1.0');
            $message->getHeaders()->addTextHeader('X-Mailer', 'PHP v' . phpversion());
            $message->getHeaders()->addParameterizedHeader('Content-type', 'text/html', ['charset' => 'utf-8']);

            $this->get('mailer')->send($message);

            $response['result'] = 'success';
        }

        return new JsonResponse($response);
    }
}
