<?php

namespace AppBundle\Controller\Secured\Api;

use AppBundle\Entity\Ukuran;
use AppBundle\Manager\UkuranManager;
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
 * @Route("/api/ukuran", name="app_secured_api_ukuran")
 */
class UkuranApiController extends Controller
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
     * @var UkuranManager
     * @Inject("manager.ukuran")
     */
    private $ukuranManager;

    /**
     * @Route("", name="app_secured_api_ukuran_get", methods={"GET"})
     */
    public function getAction(Request $request)
    {
        $ukurans = $this->ukuranManager->findAll();

        return new Response($this->serializer->serialize($ukurans, 'json',
            SerializationContext::create()->setGroups(['ukuran'])->enableMaxDepthChecks()));
    }

    /**
     * @Route("/get-dropdown-aktif", name="app_secured_api_ukuran_get_dropdown_aktif", methods={"GET"})
     */
    public function getDropdownAllAction(Request $request)
    {
        $ukurans = $this->ukuranManager->findAllAktif();

        return new Response($this->serializer->serialize($ukurans, 'json',
            SerializationContext::create()->setGroups(['dropdown'])->enableMaxDepthChecks()));
    }

    /**
     * @Route("/{id}", name="app_secured_api_ukuran_delete", methods={"DELETE"})
     * @ParamConverter("ukuran", class="AppBundle:Ukuran", options={"mapping": {"id": "id"}})
     */
    public function deleteAction(Ukuran $ukuran, Request $request)
    {
        $response = [
            'result' => 'error',
            'errors' => []
        ];

        $this->ukuranManager->remove($ukuran);
        $response['result'] = 'success';

        return new JsonResponse($response);
    }

    /**
     * @Route("/{id}", name="app_secured_api_ukuran_update", methods={"PUT"})
     * @ParamConverter("ukuran", class="AppBundle:Ukuran", options={"mapping": {"id": "id"}})
     */
    public function updateAction(Ukuran $ukuran, Request $request)
    {
        $response = [
            'result' => 'error',
            'ukuran' => null,
            'errors' => []
        ];

        $this->ukuranManager->assignRequest($ukuran, $request);

        $errorList = $this->validator->validate($ukuran, ['Default']);

        if (count($errorList)) {
            foreach ($errorList as $error) {
                /** @var ConstraintViolation $error */
                $response['errors'][$error->getPropertyPath()] = $error->getMessage();
            }
        } else {
            $this->ukuranManager->save($ukuran);

            $response['ukuran'] = json_decode($this->serializer->serialize($ukuran, 'json',
                SerializationContext::create()->setGroups(['ukuran'])->enableMaxDepthChecks()));
            $response['result'] = 'success';
        }

        return new JsonResponse($response);
    }

    /**
     * @Route("", name="app_secured_api_ukuran_create", methods={"POST"})
     */
    public function createAction(Request $request)
    {
        $response = [
            'result' => 'error',
            'ukuran' => null,
            'errors' => []
        ];

        $ukuran = new Ukuran();

        $this->ukuranManager->assignRequest($ukuran, $request);

        $errorList = $this->validator->validate($ukuran, ['create', 'Default']);

        if (count($errorList)) {
            foreach ($errorList as $error) {
                /** @var ConstraintViolation $error */
                $response['errors'][$error->getPropertyPath()] = $error->getMessage();
            }
        } else {
            $this->ukuranManager->save($ukuran);

            $response['ukuran'] = json_decode($this->serializer->serialize($ukuran, 'json',
                SerializationContext::create()->setGroups(['ukuran'])->enableMaxDepthChecks()));
            $response['result'] = 'success';
        }

        return new JsonResponse($response);
    }

    /**
     * @Route("/toogle/{id}", name="app_secured_api_ukuran_toogle", methods={"POST"})
     * @ParamConverter("ukuran", class="AppBundle:Ukuran", options={"mapping": {"id": "id"}})
     */
    public function toogleAction(Ukuran $ukuran, Request $request)
    {
        $response = [
            'result' => 'error',
            'ukuran' => null,
            'errors' => []
        ];

        $ukuran->setAktif(!$ukuran->getAktif());
        $this->ukuranManager->save($ukuran);

        $response['ukuran'] = json_decode($this->get('serializer')->serialize($ukuran, 'json',
            SerializationContext::create()->setGroups(['ukuran'])->enableMaxDepthChecks()));
        $response['result'] = 'success';

        return new JsonResponse($response);
    }
}
