<?php

namespace AppBundle\Controller\Secured\Api;

use AppBundle\Entity\Aksesoris;
use AppBundle\Entity\Kendaraan;
use AppBundle\Manager\AksesorisManager;
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
 * @Route("/api/aksesoris", name="app_secured_api_aksesoris")
 */
class AksesorisApiController extends Controller
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
     * @var AksesorisManager
     * @Inject("manager.aksesoris")
     */
    private $aksesorisManager;

    /**
     * @Route("", name="app_secured_api_aksesoris_get", methods={"GET"})
     */
    public function getAction(Request $request)
    {
        $aksesoriss = $this->aksesorisManager->findAll();

        return new Response($this->serializer->serialize($aksesoriss, 'json',
            SerializationContext::create()->setGroups(['aksesoris'])->enableMaxDepthChecks()));
    }

    /**
     * @Route("/kendaraan/{id}", name="app_secured_api_aksesoris_get_kendaraan", methods={"GET"})
     * @ParamConverter("kendaraan", class="AppBundle:Kendaraan", options={"mapping": {"id": "id"}})
     */
    public function getKendaraanAction(Kendaraan $kendaraan, Request $request)
    {
        $aksesoriss = $this->aksesorisManager->findAllByKendaraanId($kendaraan->getId());

        return new Response($this->serializer->serialize($aksesoriss, 'json',
            SerializationContext::create()->setGroups(['aksesoris'])->enableMaxDepthChecks()));
    }

    /**
     * @Route("/get-dropdown-aktif", name="app_secured_api_aksesoris_get_dropdown_aktif", methods={"GET"})
     */
    public function getDropdownAllAction(Request $request)
    {
        $aksesoriss = $this->aksesorisManager->findAllAktif();

        return new Response($this->serializer->serialize($aksesoriss, 'json',
            SerializationContext::create()->setGroups(['dropdown'])->enableMaxDepthChecks()));
    }

    /**
     * @Route("/{id}", name="app_secured_api_aksesoris_delete", methods={"DELETE"})
     * @ParamConverter("aksesoris", class="AppBundle:Aksesoris", options={"mapping": {"id": "id"}})
     */
    public function deleteAction(Aksesoris $aksesoris, Request $request)
    {
        $response = [
            'result' => 'error',
            'errors' => []
        ];

        $this->aksesorisManager->remove($aksesoris);
        $response['result'] = 'success';

        return new JsonResponse($response);
    }

    /**
     * @Route("/{id}", name="app_secured_api_aksesoris_update", methods={"PUT"})
     * @ParamConverter("aksesoris", class="AppBundle:Aksesoris", options={"mapping": {"id": "id"}})
     */
    public function updateAction(Aksesoris $aksesoris, Request $request)
    {
        $response = [
            'result'    => 'error',
            'aksesoris' => null,
            'errors'    => []
        ];

        $this->aksesorisManager->assignRequest($aksesoris, $request);

        $errorList = $this->validator->validate($aksesoris, ['Default']);

        if (count($errorList)) {
            foreach ($errorList as $error) {
                /** @var ConstraintViolation $error */
                $response['errors'][$error->getPropertyPath()] = $error->getMessage();
            }
        } else {
            $this->aksesorisManager->save($aksesoris);

            $response['aksesoris'] = json_decode($this->serializer->serialize($aksesoris, 'json',
                SerializationContext::create()->setGroups(['aksesoris'])->enableMaxDepthChecks()));
            $response['result']    = 'success';
        }

        return new JsonResponse($response);
    }

    /**
     * @Route("/{id}", name="app_secured_api_aksesoris_create", methods={"POST"})
     * @ParamConverter("kendaraan", class="AppBundle:Kendaraan", options={"mapping": {"id": "id"}})
     */
    public function createAction(Kendaraan $kendaraan, Request $request)
    {
        $response = [
            'result'    => 'error',
            'aksesoris' => null,
            'errors'    => []
        ];

        $aksesoris = new Aksesoris();
        $aksesoris->setKendaraan($kendaraan);

        $this->aksesorisManager->assignRequest($aksesoris, $request);

        $errorList = $this->validator->validate($aksesoris, ['create', 'Default']);

        if (count($errorList)) {
            foreach ($errorList as $error) {
                /** @var ConstraintViolation $error */
                $response['errors'][$error->getPropertyPath()] = $error->getMessage();
            }
        } else {
            $this->aksesorisManager->save($aksesoris);

            $response['aksesoris'] = json_decode($this->serializer->serialize($aksesoris, 'json',
                SerializationContext::create()->setGroups(['aksesoris'])->enableMaxDepthChecks()));
            $response['result']    = 'success';
        }

        return new JsonResponse($response);
    }

    /**
     * @Route("/toogle/{id}", name="app_secured_api_aksesoris_toogle", methods={"POST"})
     * @ParamConverter("aksesoris", class="AppBundle:Aksesoris", options={"mapping": {"id": "id"}})
     */
    public function toogleAction(Aksesoris $aksesoris, Request $request)
    {
        $response = [
            'result'    => 'error',
            'aksesoris' => null,
            'errors'    => []
        ];

        $aksesoris->setAktif(!$aksesoris->getAktif());
        $this->aksesorisManager->save($aksesoris);

        $response['aksesoris'] = json_decode($this->get('serializer')->serialize($aksesoris, 'json',
            SerializationContext::create()->setGroups(['aksesoris'])->enableMaxDepthChecks()));
        $response['result']    = 'success';

        return new JsonResponse($response);
    }
}
