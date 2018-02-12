<?php

namespace AppBundle\Controller\Secured\Api;

use AppBundle\Entity\Part;
use AppBundle\Manager\PartManager;
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
 * @Route("/api/part", name="app_secured_api_kategori_part")
 */
class PartApiController extends Controller
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
     * @var PartManager
     * @Inject("manager.part")
     */
    private $partManager;

    /**
     * @Route("", name="app_secured_api_part_get", methods={"GET"})
     */
    public function getAction(Request $request)
    {
        $parts = $this->partManager->findAll();

        return new Response($this->serializer->serialize($parts, 'json',
            SerializationContext::create()->setGroups(['part'])->enableMaxDepthChecks()));
    }

    /**
     * @Route("/get-dropdown-aktif", name="app_secured_api_part_get_dropdown_aktif", methods={"GET"})
     */
    public function getDropdownAllAction(Request $request)
    {
        $parts = $this->partManager->findAllAktif();

        return new Response($this->serializer->serialize($parts, 'json',
            SerializationContext::create()->setGroups(['dropdown'])->enableMaxDepthChecks()));
    }

    /**
     * @Route("/{id}", name="app_secured_api_part_delete", methods={"DELETE"})
     * @ParamConverter("part", class="AppBundle:Part", options={"mapping": {"id": "id"}})
     */
    public function deleteAction(Part $part, Request $request)
    {
        $response = [
            'result' => 'error',
            'errors' => []
        ];

        $this->partManager->remove($part);
        $response['result'] = 'success';

        return new JsonResponse($response);
    }

    /**
     * @Route("/{id}", name="app_secured_api_part_update", methods={"PUT"})
     * @ParamConverter("part", class="AppBundle:Part", options={"mapping": {"id": "id"}})
     */
    public function updateAction(Part $part, Request $request)
    {
        $response = [
            'result' => 'error',
            'part'   => null,
            'errors' => []
        ];

        $this->partManager->assignRequest($part, $request);

        $errorList = $this->validator->validate($part, ['Default']);

        if (count($errorList)) {
            foreach ($errorList as $error) {
                /** @var ConstraintViolation $error */
                $response['errors'][$error->getPropertyPath()] = $error->getMessage();
            }
        } else {
            $this->partManager->save($part);

            $response['part']   = json_decode($this->serializer->serialize($part, 'json',
                SerializationContext::create()->setGroups(['part'])->enableMaxDepthChecks()));
            $response['result'] = 'success';
        }

        return new JsonResponse($response);
    }

    /**
     * @Route("", name="app_secured_api_part_create", methods={"POST"})
     */
    public function createAction(Request $request)
    {
        $response = [
            'result' => 'error',
            'part'   => null,
            'errors' => []
        ];

        $part = new Part();

        $this->partManager->assignRequest($part, $request);

        $errorList = $this->validator->validate($part, ['create', 'Default']);

        if (count($errorList)) {
            foreach ($errorList as $error) {
                /** @var ConstraintViolation $error */
                $response['errors'][$error->getPropertyPath()] = $error->getMessage();
            }
        } else {
            $this->partManager->save($part);

            $response['part']   = json_decode($this->serializer->serialize($part, 'json',
                SerializationContext::create()->setGroups(['part'])->enableMaxDepthChecks()));
            $response['result'] = 'success';
        }

        return new JsonResponse($response);
    }

    /**
     * @Route("/toogle/{id}", name="app_secured_api_part_toogle", methods={"POST"})
     * @ParamConverter("part", class="AppBundle:Part", options={"mapping": {"id": "id"}})
     */
    public function toogleAction(Part $part, Request $request)
    {
        $response = [
            'result' => 'error',
            'part'   => null,
            'errors' => []
        ];

        $part->setAktif(!$part->getAktif());
        $this->partManager->save($part);

        $response['part']   = json_decode($this->get('serializer')->serialize($part, 'json',
            SerializationContext::create()->setGroups(['part'])->enableMaxDepthChecks()));
        $response['result'] = 'success';

        return new JsonResponse($response);
    }
}
