<?php

namespace AppBundle\Controller\Front\Api;

use AppBundle\Entity\EmailSubscribe;
use AppBundle\Manager\EmailSubscribeManager;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\Serializer\Serializer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolation;

/**
 * Class EmailSubscribeApiController
 *
 * @package AppBundle\Controller\Front\Api
 *
 * @Route(path="/api/email-subscribe", name="app_api_email_subscribe")
 */
class EmailSubscribeApiController extends Controller
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
     * @Route("", name="app_api_email_subscribe_subscribe", methods={"POST"})
     */
    public function subscribeAction(Request $request)
    {
        $response = [
            'result' => 'error',
            'errors' => []
        ];

        $emailSubscribe = new EmailSubscribe();

        $this->emailSubscribeManager->assignRequest($emailSubscribe, $request);

        $errorList = $this->get('validator')->validate($emailSubscribe, ['create', 'Default']);

        if (count($errorList)) {
            foreach ($errorList as $error) {
                /** @var ConstraintViolation $error */
                $response['errors'][$error->getPropertyPath()] = $error->getMessage();
            }
        } else {
            $emailSubscribe->setAktif(true);
            $this->emailSubscribeManager->save($emailSubscribe);

            $message = \Swift_Message::newInstance()
                ->setSubject('Terima kasih telah subscribe.')
                ->setFrom('noreply@bahanayamaha.com')
                ->setReplyTo("support@bahanayamaha.com")
                ->setTo($emailSubscribe->getEmail())
                ->setCc("support@bahanayamaha.com")
                ->setBcc('ehs.hantan@gmail.com')
                ->setBody(
                    $this->renderView(
                        'AppBundle:Front/Email:thxforSubscribeEmail.html.twig',
                        [
                            'emailSubscribe' => $emailSubscribe
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
