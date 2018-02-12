<?php

namespace AppBundle\Controller\Secured\Api;

use AppBundle\Entity\HargaOTR;
use AppBundle\Entity\Kendaraan;
use AppBundle\Manager\HargaOTRManager;
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
 * @Route("/api/harga-otr", name="app_secured_api_harga_otr")
 */
class HargaOTRApiController extends Controller
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
     * @var HargaOTRManager
     * @Inject("manager.hargaOTR")
     */
    private $hargaOTRManager;

    /**
     * @Route("", name="app_secured_api_harga_otr_get", methods={"GET"})
     */
    public function getAction(Request $request)
    {
        $hargaOTRs = $this->hargaOTRManager->findAll();

        return new Response($this->serializer->serialize($hargaOTRs, 'json',
            SerializationContext::create()->setGroups(['hargaOTR'])->enableMaxDepthChecks()));
    }

    /**
     * @Route("/kendaraan/{id}", name="app_secured_api_harga_otr_get_kendaraan", methods={"GET"})
     * @ParamConverter("kendaraan", class="AppBundle:Kendaraan", options={"mapping": {"id": "id"}})
     */
    public function getKendaraanAction(Kendaraan $kendaraan, Request $request)
    {
        $hargaOTRs = $this->hargaOTRManager->findAllByKendaraanId($kendaraan->getId());

        return new Response($this->serializer->serialize($hargaOTRs, 'json',
            SerializationContext::create()->setGroups(['hargaOTR'])->enableMaxDepthChecks()));
    }

    /**
     * @Route("/{id}", name="app_secured_api_harga_otr_delete", methods={"DELETE"})
     * @ParamConverter("hargaOTR", class="AppBundle:HargaOTR", options={"mapping": {"id": "id"}})
     */
    public function deleteAction(HargaOTR $hargaOTR, Request $request)
    {
        $response = [
            'result' => 'error',
            'errors' => []
        ];

        $this->hargaOTRManager->remove($hargaOTR);
        $response['result'] = 'success';

        return new JsonResponse($response);
    }

    /**
     * @Route("/{id}", name="app_secured_api_harga_otr_update", methods={"PUT"})
     * @ParamConverter("hargaOTR", class="AppBundle:HargaOTR", options={"mapping": {"id": "id"}})
     */
    public function updateAction(HargaOTR $hargaOTR, Request $request)
    {
        $response = [
            'result'   => 'error',
            'hargaOTR' => null,
            'errors'   => []
        ];

        $this->hargaOTRManager->assignRequest($hargaOTR, $request);

        $errorList = $this->validator->validate($hargaOTR, ['Default']);

        if (count($errorList)) {
            foreach ($errorList as $error) {
                /** @var ConstraintViolation $error */
                $response['errors'][$error->getPropertyPath()] = $error->getMessage();
            }
        } else {
            $this->hargaOTRManager->save($hargaOTR);

            $response['hargaOTR'] = json_decode($this->serializer->serialize($hargaOTR, 'json',
                SerializationContext::create()->setGroups(['hargaOTR'])->enableMaxDepthChecks()));
            $response['result']   = 'success';
        }

        return new JsonResponse($response);
    }

    /**
     * @Route("", name="app_secured_api_harga_otr_create", methods={"POST"})
     */
    public function createAction(Request $request)
    {
        $response = [
            'result'   => 'error',
            'hargaOTR' => null,
            'errors'   => []
        ];

        $hargaOTR = new HargaOTR();

        $this->hargaOTRManager->assignRequest($hargaOTR, $request);

        $errorList = $this->validator->validate($hargaOTR, ['create', 'Default']);

        if (count($errorList)) {
            foreach ($errorList as $error) {
                /** @var ConstraintViolation $error */
                $response['errors'][$error->getPropertyPath()] = $error->getMessage();
            }
        } else {
            $this->hargaOTRManager->save($hargaOTR);

            $response['hargaOTR'] = json_decode($this->serializer->serialize($hargaOTR, 'json',
                SerializationContext::create()->setGroups(['hargaOTR'])->enableMaxDepthChecks()));
            $response['result']   = 'success';
        }

        return new JsonResponse($response);
    }
}
