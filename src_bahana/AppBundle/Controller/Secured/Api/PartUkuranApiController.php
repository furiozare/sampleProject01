<?php

namespace AppBundle\Controller\Secured\Api;

use AppBundle\Entity\Part;
use AppBundle\Entity\PartUkuran;
use AppBundle\Manager\PartUkuranManager;
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
 * @Route("/api/part-ukuran", name="app_secured_api_part_ukuran")
 */
class PartUkuranApiController extends Controller
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
     * @var PartUkuranManager
     * @Inject("manager.partUkuran")
     */
    private $partUkuranManager;

    /**
     * @Route("", name="app_secured_api_part_ukuran_get", methods={"GET"})
     */
    public function getAction(Request $request)
    {
        $partUkurans = $this->partUkuranManager->findAll();

        return new Response($this->serializer->serialize($partUkurans, 'json',
            SerializationContext::create()->setGroups(['partUkuran'])->enableMaxDepthChecks()));
    }

    /**
     * @Route("/part/{id}", name="app_secured_api_part_ukuran_get_part", methods={"GET"})
     * @ParamConverter("part", class="AppBundle:Part", options={"mapping": {"id": "id"}})
     */
    public function getPartAction(Part $part, Request $request)
    {
        $partUkurans = $this->partUkuranManager->findAllByPartId($part->getId());

        return new Response($this->serializer->serialize($partUkurans, 'json',
            SerializationContext::create()->setGroups(['partUkuran'])->enableMaxDepthChecks()));
    }

    /**
     * @Route("/get-dropdown-aktif", name="app_secured_api_part_ukuran_get_dropdown_aktif", methods={"GET"})
     */
    public function getDropdownAllAction(Request $request)
    {
        $partUkurans = $this->partUkuranManager->findAll();

        return new Response($this->serializer->serialize($partUkurans, 'json',
            SerializationContext::create()->setGroups(['dropdown'])->enableMaxDepthChecks()));
    }

    /**
     * @Route("/{id}", name="app_secured_api_part_ukuran_delete", methods={"DELETE"})
     * @ParamConverter("partUkuran", class="AppBundle:PartUkuran", options={"mapping": {"id": "id"}})
     */
    public function deleteAction(PartUkuran $partUkuran, Request $request)
    {
        $response = [
            'result' => 'error',
            'errors' => []
        ];

        $this->partUkuranManager->remove($partUkuran);
        $response['result'] = 'success';

        return new JsonResponse($response);
    }

    /**
     * @Route("/{id}", name="app_secured_api_part_ukuran_update", methods={"PUT"})
     * @ParamConverter("partUkuran", class="AppBundle:PartUkuran", options={"mapping": {"id": "id"}})
     */
    public function updateAction(PartUkuran $partUkuran, Request $request)
    {
        $response = [
            'result'     => 'error',
            'partUkuran' => null,
            'errors'     => []
        ];

        $this->partUkuranManager->assignRequest($partUkuran, $request);

        $errorList = $this->validator->validate($partUkuran, ['Default']);

        if (count($errorList)) {
            foreach ($errorList as $error) {
                /** @var ConstraintViolation $error */
                $response['errors'][$error->getPropertyPath()] = $error->getMessage();
            }
        } else {
            $this->partUkuranManager->save($partUkuran);

            $response['partUkuran'] = json_decode($this->serializer->serialize($partUkuran, 'json',
                SerializationContext::create()->setGroups(['partUkuran'])->enableMaxDepthChecks()));
            $response['result']     = 'success';
        }

        return new JsonResponse($response);
    }

    /**
     * @Route("/{id}", name="app_secured_api_part_ukuran_create", methods={"POST"})
     * @ParamConverter("part", class="AppBundle:Part", options={"mapping": {"id": "id"}})
     */
    public function createAction(Part $part, Request $request)
    {
        $response = [
            'result'     => 'error',
            'partUkuran' => null,
            'errors'     => []
        ];

        $partUkuran = new PartUkuran();
        $partUkuran->setPart($part);

        $this->partUkuranManager->assignRequest($partUkuran, $request);

        $errorList = $this->validator->validate($partUkuran, ['create', 'Default']);

        if (count($errorList)) {
            foreach ($errorList as $error) {
                /** @var ConstraintViolation $error */
                $response['errors'][$error->getPropertyPath()] = $error->getMessage();
            }
        } else {
            $this->partUkuranManager->save($partUkuran);

            $response['partUkuran'] = json_decode($this->serializer->serialize($partUkuran, 'json',
                SerializationContext::create()->setGroups(['partUkuran'])->enableMaxDepthChecks()));
            $response['result']     = 'success';
        }

        return new JsonResponse($response);
    }
}
