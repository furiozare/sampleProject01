<?php

namespace AppBundle\Controller\Secured;

use AppBundle\Entity\Propinsi;
use AppBundle\Manager\PropinsiManager;
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
 * @Route("/propinsi", name="app_secured_propinsi")
 */
class PropinsiController extends Controller
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
     * @var PropinsiManager
     * @Inject("manager.propinsi")
     */
    private $propinsiManager;

    /**
     * @Route("/", name="app_secured_propinsi_index", methods={"GET"})
     */
    public function indexAction(Request $request)
    {
        return $this->render('AppBundle:Secured/Propinsi:index.html.twig', []);
    }

    /**
     * @Route("/get", name="app_secured_propinsi_get")
     */
    public function getAction(Request $request)
    {
        $propinsis = $this->propinsiManager->findAll();

        return new Response($this->serializer->serialize($propinsis, 'json',
            SerializationContext::create()->setGroups(['propinsi'])->enableMaxDepthChecks()));
    }

    /**
     * @Route("/get-dropdown-all", name="app_secured_propinsi_get_dropdown_all")
     */
    public function getDropdownAllAction(Request $request)
    {
        $propinsis = $this->propinsiManager->findAll();

        return new Response($this->serializer->serialize($propinsis, 'json',
            SerializationContext::create()->setGroups(['dropdown'])->enableMaxDepthChecks()));
    }

    /**
     * @Route("/{id}", name="app_secured_propinsi_delete", methods={"DELETE"})
     * @ParamConverter("propinsi", class="AppBundle:Propinsi", options={"mapping": {"id": "id"}})
     */
    public function deleteAction(Propinsi $propinsi, Request $request)
    {
        $response = [
            'result' => 'error',
            'errors' => []
        ];

        $this->propinsiManager->remove($propinsi);
        $response['result'] = 'success';

        return new JsonResponse($response);
    }

    /**
     * @Route("/{id}", name="app_secured_propinsi_update", methods={"PUT"})
     * @ParamConverter("propinsi", class="AppBundle:Propinsi", options={"mapping": {"id": "id"}})
     */
    public function updateAction(Propinsi $propinsi, Request $request)
    {
        $response = [
            'result'   => 'error',
            'propinsi' => null,
            'errors'   => []
        ];

        $this->propinsiManager->assignRequest($propinsi, $request);

        $errorList = $this->validator->validate($propinsi, ['Default']);

        if (count($errorList)) {
            foreach ($errorList as $error) {
                /** @var ConstraintViolation $error */
                $response['errors'][$error->getPropertyPath()] = $error->getMessage();
            }
        } else {
            $this->propinsiManager->save($propinsi);

            $response['propinsi'] = json_decode($this->serializer->serialize($propinsi, 'json',
                SerializationContext::create()->setGroups(['propinsi'])->enableMaxDepthChecks()));
            $response['result']   = 'success';
        }

        return new JsonResponse($response);
    }

    /**
     * @Route("/", name="app_secured_propinsi_create", methods={"POST"})
     */
    public function createAction(Request $request)
    {
        $response = [
            'result'   => 'error',
            'propinsi' => null,
            'errors'   => []
        ];

        $propinsi = new Propinsi();

        $this->propinsiManager->assignRequest($propinsi, $request);

        $errorList = $this->validator->validate($propinsi, ['create', 'Default']);

        if (count($errorList)) {
            foreach ($errorList as $error) {
                /** @var ConstraintViolation $error */
                $response['errors'][$error->getPropertyPath()] = $error->getMessage();
            }
        } else {
            $this->propinsiManager->save($propinsi);

            $response['propinsi'] = json_decode($this->serializer->serialize($propinsi, 'json',
                SerializationContext::create()->setGroups(['propinsi'])->enableMaxDepthChecks()));
            $response['result']   = 'success';
        }

        return new JsonResponse($response);
    }

    /**
     * @Route("/toogle/{id}", name="app_secured_propinsi_toogle", methods={"POST"})
     * @ParamConverter("propinsi", class="AppBundle:Propinsi", options={"mapping": {"id": "id"}})
     */
    public function toogleAction(Propinsi $propinsi, Request $request)
    {
        $response = [
            'result'   => 'error',
            'propinsi' => null,
            'errors'   => []
        ];

        $propinsi->setAktif(!$propinsi->getAktif());
        $this->propinsiManager->save($propinsi);

        $response['propinsi'] = json_decode($this->get('serializer')->serialize($propinsi, 'json',
            SerializationContext::create()->setGroups(['propinsi'])->enableMaxDepthChecks()));
        $response['result']   = 'success';

        return new JsonResponse($response);
    }
}
