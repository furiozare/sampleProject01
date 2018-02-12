<?php

namespace AppBundle\Controller\Front;

use AppBundle\Entity\BookingService;
use AppBundle\Manager\BookingServiceManager;
use AppBundle\Manager\SettingManager;
use JMS\DiExtraBundle\Annotation\Inject;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolation;

/**
 * Class ServiceController
 *
 * @package AppBundle\Controller\Front
 *
 * @Route(path="/service", name="app_service")
 */
class ServiceController extends Controller
{
    /**
     * @var SettingManager
     * @Inject("manager.setting")
     */
    private $settingManager;

    /**
     * @var BookingServiceManager
     * @Inject("manager.bookingservice")
     */
    private $bookingServiceManager;

    /**
     * @Route(path="/", name="app_service_index", methods={"GET"})
     */
    public function indexAction(Request $request)
    {
        $service = $this->settingManager->getServiceSetting();

        return $this->render('AppBundle:Front/Service:index.html.twig', [
            'service' => $service
        ]);
    }

    /**
     * @Route("/", name="app_service_save", methods={"POST"})
     */
    public function saveAction(Request $request)
    {
        $response = [
            'result'  => 'error',
            'service' => null,
            'errors'  => []
        ];

        $bookingService = new BookingService();

        $this->bookingServiceManager->assignRequest($bookingService, $request);

        $errorList = $this->get('validator')->validate($bookingService, ['create', 'Default']);

        if (count($errorList)) {
            foreach ($errorList as $error) {
                /** @var ConstraintViolation $error */
                $response['errors'][$error->getPropertyPath()] = $error->getMessage();
            }
        } else {
            $this->bookingServiceManager->save($bookingService);

            $message = \Swift_Message::newInstance()
                ->setSubject('Booking Service Berhasil')
                ->setFrom('noreply@bahanayamaha.com')
                ->setTo($bookingService->getEmail())
                ->setBody(
                    $this->renderView(
                        'AppBundle:Front/Email:bookingServiceEmail.html.twig',
                        [
                            'bookingService' => $bookingService
                        ]
                    ),
                    'text/html'
                );
            $this->get('mailer')->send($message);

            $message = \Swift_Message::newInstance()
                ->setSubject('New Booking Service')
                ->setFrom('noreply@bahanayamaha.com')
                ->setTo($bookingService->getDealer()->getEmailService())
                ->setBody(
                    $this->renderView(
                        'AppBundle:Front/Email:bookingServiceEmail.html.twig',
                        [
                            'bookingService' => $bookingService
                        ]
                    ),
                    'text/html'
                );
            $this->get('mailer')->send($message);

            $response['result'] = 'success';
        }

        return new JsonResponse($response);
    }
}
