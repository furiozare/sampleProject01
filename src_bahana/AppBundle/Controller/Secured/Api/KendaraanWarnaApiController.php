<?php

namespace AppBundle\Controller\Secured\Api;

use AppBundle\Entity\Kendaraan;
use AppBundle\Entity\KendaraanWarna;
use AppBundle\Manager\KendaraanWarnaManager;
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
 * @Route("/api/kendaraan-warna", name="app_secured_api_kendaraan_warna")
 */
class KendaraanWarnaApiController extends Controller
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
     * @var KendaraanWarnaManager
     * @Inject("manager.kendaraanWarna")
     */
    private $kendaraanWarnaManager;

    /**
     * @Route("", name="app_secured_api_kendaraan_warna_get", methods={"GET"})
     */
    public function getAction(Request $request)
    {
        $kendaraanWarnas = $this->kendaraanWarnaManager->findAll();

        return new Response($this->serializer->serialize($kendaraanWarnas, 'json',
            SerializationContext::create()->setGroups(['kendaraanWarna'])->enableMaxDepthChecks()));
    }

    /**
     * @Route("/{id}", name="app_secured_api_kendaraan_warna_get_kendaraan", methods={"GET"})
     * @ParamConverter("kendaraan", class="AppBundle:Kendaraan", options={"mapping": {"id": "id"}})
     */
    public function getKendaraanAction(Kendaraan $kendaraan, Request $request)
    {
        $kendaraanWarnas = $this->kendaraanWarnaManager->findByKendaraanId($kendaraan->getId());

        return new Response($this->serializer->serialize($kendaraanWarnas, 'json',
            SerializationContext::create()->setGroups(['kendaraanWarna'])->enableMaxDepthChecks()));
    }

    /**
     * @Route("/{id}", name="app_secured_api_kendaraan_warna_delete", methods={"DELETE"})
     * @ParamConverter("kendaraanWarna", class="AppBundle:KendaraanWarna", options={"mapping": {"id": "id"}})
     */
    public function deleteAction(KendaraanWarna $kendaraanWarna, Request $request)
    {
        $response = [
            'result' => 'error',
            'errors' => []
        ];

        $this->kendaraanWarnaManager->remove($kendaraanWarna);
        $response['result'] = 'success';

        return new JsonResponse($response);
    }

    /**
     * @Route("", name="app_secured_api_kendaraan_warna_create", methods={"POST"})
     */
    public function createAction(Request $request)
    {
        $response = [
            'result'         => 'error',
            'kendaraanWarna' => null,
            'errors'         => []
        ];

        $kendaraanWarna = new KendaraanWarna();

        $this->kendaraanWarnaManager->assignRequest($kendaraanWarna, $request);

        $errorList = $this->validator->validate($kendaraanWarna, ['create', 'Default']);

        if (count($errorList)) {
            foreach ($errorList as $error) {
                /** @var ConstraintViolation $error */
                $response['errors'][$error->getPropertyPath()] = $error->getMessage();
            }
        } else {
            $this->kendaraanWarnaManager->save($kendaraanWarna);

            $response['kendaraanWarna'] = json_decode($this->serializer->serialize($kendaraanWarna, 'json',
                SerializationContext::create()->setGroups(['kendaraanWarna'])->enableMaxDepthChecks()));
            $response['result']         = 'success';
        }

        return new JsonResponse($response);
    }
}
