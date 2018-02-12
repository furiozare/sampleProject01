<?php

namespace AppBundle\Controller\Secured\Api;

use AppBundle\Entity\EmailSubscribe;
use AppBundle\Manager\EmailSubscribeManager;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator;

/**
 * @Route("/api/email-subscribe", name="app_secured_api_email_subscribe")
 */
class EmailSubscribeApiController extends Controller
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
     * @var EmailSubscribeManager
     * @Inject("manager.emailSubscribe")
     */
    private $emailSubscribeManager;

    /**
     * @Route("", name="app_secured_api_email_subscribe_get", methods={"GET"})
     */
    public function getAction(Request $request)
    {
        $emailSubscribes = $this->emailSubscribeManager->findAll();

        return new Response($this->serializer->serialize($emailSubscribes, 'json',
            SerializationContext::create()->setGroups(['emailSubscribe'])->enableMaxDepthChecks()));
    }

    /**
     * @Route("/toogle-active/{id}", name="app_secured_api_email_subscribe_toogle_active", methods={"POST"})
     * @Extra\ParamConverter("emailSubscribe", class="AppBundle:EmailSubscribe", options={"mapping": {"id": "id"}})
     */
    public function toogleActiveAction(EmailSubscribe $emailSubscribe, Request $request)
    {
        $response = [
            'result'         => 'error',
            'emailSubscribe' => null,
            'errors'         => []
        ];

        $emailSubscribe->setAktif(!$emailSubscribe->getAktif());
        $this->emailSubscribeManager->save($emailSubscribe);

        $response['emailSubscribe'] = json_decode($this->serializer->serialize($emailSubscribe, 'json',
            SerializationContext::create()->setGroups(['emailSubscribe'])->enableMaxDepthChecks()));
        $response['result'] = 'success';

        return new JsonResponse($response);
    }
}
