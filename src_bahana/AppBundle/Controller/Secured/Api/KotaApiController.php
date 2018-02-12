<?php

namespace AppBundle\Controller\Secured\Api;

use AppBundle\Entity\Kota;
use AppBundle\Manager\KotaManager;
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
 * @Route("/api/kota", name="app_secured_api_kota")
 */
class KotaApiController extends Controller
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
     * @var KotaManager
     * @Inject("manager.kota")
     */
    private $kotaManager;

    /**
     * @Route("", name="app_secured_api_kota_get", methods={"GET"})
     */
    public function getAction(Request $request)
    {
        $kotas = $this->kotaManager->findAll();

        return new Response($this->serializer->serialize($kotas, 'json',
            SerializationContext::create()->setGroups(['kota'])->enableMaxDepthChecks()));
    }

    /**
     * @Route("/get-dropdown-aktif", name="app_secured_api_kota_get_dropdown_aktif", methods={"GET"})
     */
    public function getDropdownAktifAction(Request $request)
    {
        $kotas = $this->kotaManager->findAllAktif();

        return new Response($this->serializer->serialize($kotas, 'json',
            SerializationContext::create()->setGroups(['dropdown'])->enableMaxDepthChecks()));
    }

    /**
     * @Route("/{id}", name="app_secured_api_kota_delete", methods={"DELETE"})
     * @ParamConverter("kota", class="AppBundle:Kota", options={"mapping": {"id": "id"}})
     */
    public function deleteAction(Kota $kota, Request $request)
    {
        $response = [
            'result' => 'error',
            'errors' => []
        ];

        $this->kotaManager->remove($kota);
        $response['result'] = 'success';

        return new JsonResponse($response);
    }

    /**
     * @Route("/{id}", name="app_secured_api_kota_update", methods={"PUT"})
     * @ParamConverter("kota", class="AppBundle:Kota", options={"mapping": {"id": "id"}})
     */
    public function updateAction(Kota $kota, Request $request)
    {
        $response = [
            'result' => 'error',
            'kota'   => null,
            'errors' => []
        ];

        $this->kotaManager->assignRequest($kota, $request);

        $errorList = $this->validator->validate($kota, ['Default']);

        if (count($errorList)) {
            foreach ($errorList as $error) {
                /** @var ConstraintViolation $error */
                $response['errors'][$error->getPropertyPath()] = $error->getMessage();
            }
        } else {
            $this->kotaManager->save($kota);

            $response['kota']   = json_decode($this->serializer->serialize($kota, 'json',
                SerializationContext::create()->setGroups(['kota'])->enableMaxDepthChecks()));
            $response['result'] = 'success';
        }

        return new JsonResponse($response);
    }

    /**
     * @Route("", name="app_secured_api_kota_create", methods={"POST"})
     */
    public function createAction(Request $request)
    {
        $response = [
            'result' => 'error',
            'kota'   => null,
            'errors' => []
        ];

        $kota = new Kota();

        $this->kotaManager->assignRequest($kota, $request);

        $errorList = $this->validator->validate($kota, ['create', 'Default']);

        if (count($errorList)) {
            foreach ($errorList as $error) {
                /** @var ConstraintViolation $error */
                $response['errors'][$error->getPropertyPath()] = $error->getMessage();
            }
        } else {
            $this->kotaManager->save($kota);

            $response['kota']   = json_decode($this->serializer->serialize($kota, 'json',
                SerializationContext::create()->setGroups(['kota'])->enableMaxDepthChecks()));
            $response['result'] = 'success';
        }

        return new JsonResponse($response);
    }

    /**
     * @Route("/toogle/{id}", name="app_secured_api_kota_toogle", methods={"POST"})
     * @ParamConverter("kota", class="AppBundle:Kota", options={"mapping": {"id": "id"}})
     */
    public function toogleAction(Kota $kota, Request $request)
    {
        $response = [
            'result' => 'error',
            'kota'   => null,
            'errors' => []
        ];

        $kota->setAktif(!$kota->getAktif());
        $this->kotaManager->save($kota);

        $response['kota']   = json_decode($this->get('serializer')->serialize($kota, 'json',
            SerializationContext::create()->setGroups(['kota'])->enableMaxDepthChecks()));
        $response['result'] = 'success';

        return new JsonResponse($response);
    }
}
