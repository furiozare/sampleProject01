<?php

namespace AppBundle\Controller\Secured;

use AppBundle\Entity\Dealer;
use AppBundle\Manager\DealerManager;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator;

/**
 * @Route("/dealer", name="app_secured_dealer")
 */
class DealerController extends Controller
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
     * @var DealerManager
     * @Inject("manager.dealer")
     */
    private $dealerManager;

    /**
     * @Route("/", name="app_secured_dealer_index", methods={"GET"})
     */
    public function indexAction(Request $request)
    {
        return $this->render('AppBundle:Secured/Dealer:index.html.twig', []);
    }

    /**
     * @Route("/get", name="app_secured_dealer_get")
     */
    public function getAction(Request $request)
    {
        $dealers = $this->dealerManager->findAll();

        return new Response($this->serializer->serialize($dealers, 'json',
            SerializationContext::create()->setGroups(['dealer'])->enableMaxDepthChecks()));
    }

    /**
     * @Route("/get-dropdown-all", name="app_secured_dealer_get_dropdown_all")
     */
    public function getDropdownAllAction(Request $request)
    {
        $dealers = $this->dealerManager->findAll();

        return new Response($this->serializer->serialize($dealers, 'json',
            SerializationContext::create()->setGroups(['dropdown'])->enableMaxDepthChecks()));
    }

    /**
     * @Route("/{id}", name="app_secured_dealer_delete", methods={"DELETE"})
     * @ParamConverter("dealer", class="AppBundle:Dealer", options={"mapping": {"id": "id"}})
     */
    public function deleteAction(Dealer $dealer, Request $request)
    {
        $response = [
            'result' => 'error',
            'errors' => []
        ];

        $this->dealerManager->remove($dealer);
        $response['result'] = 'success';

        return new JsonResponse($response);
    }

    /**
     * @Route("/{id}", name="app_secured_dealer_update", methods={"PUT"})
     * @ParamConverter("dealer", class="AppBundle:Dealer", options={"mapping": {"id": "id"}})
     */
    public function updateAction(Dealer $dealer, Request $request)
    {
        $response = [
            'result' => 'error',
            'dealer' => null,
            'errors' => []
        ];

        $this->dealerManager->assignRequest($dealer, $request);

        $errorList = $this->validator->validate($dealer, ['Default']);

        if (count($errorList)) {
            foreach ($errorList as $error) {
                /** @var ConstraintViolation $error */
                $response['errors'][$error->getPropertyPath()] = $error->getMessage();
            }
        } else {
            $this->dealerManager->save($dealer);

            $response['dealer'] = json_decode($this->serializer->serialize($dealer, 'json',
                SerializationContext::create()->setGroups(['dealer'])->enableMaxDepthChecks()));
            $response['result'] = 'success';
        }

        return new JsonResponse($response);
    }

    /**
     * @Route("/", name="app_secured_dealer_create", methods={"POST"})
     */
    public function createAction(Request $request)
    {
        $response = [
            'result' => 'error',
            'dealer' => null,
            'errors' => []
        ];

        $dealer = new Dealer();

        $this->dealerManager->assignRequest($dealer, $request);

        $errorList = $this->validator->validate($dealer, ['create', 'Default']);

        if (count($errorList)) {
            foreach ($errorList as $error) {
                /** @var ConstraintViolation $error */
                $response['errors'][$error->getPropertyPath()] = $error->getMessage();
            }
        } else {
            $this->dealerManager->save($dealer);

            $response['dealer'] = json_decode($this->serializer->serialize($dealer, 'json',
                SerializationContext::create()->setGroups(['dealer'])->enableMaxDepthChecks()));
            $response['result'] = 'success';
        }

        return new JsonResponse($response);
    }

    /**
     * @Route("/toogle/{id}", name="app_secured_dealer_toogle", methods={"POST"})
     * @ParamConverter("dealer", class="AppBundle:Dealer", options={"mapping": {"id": "id"}})
     */
    public function toogleAction(Dealer $dealer, Request $request)
    {
        $response = [
            'result' => 'error',
            'dealer' => null,
            'errors' => []
        ];

        $dealer->setAktif(!$dealer->getAktif());
        $this->dealerManager->save($dealer);

        $response['dealer'] = json_decode($this->get('serializer')->serialize($dealer, 'json',
            SerializationContext::create()->setGroups(['dealer'])->enableMaxDepthChecks()));
        $response['result'] = 'success';

        return new JsonResponse($response);
    }
}
