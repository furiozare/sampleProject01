<?php

namespace AppBundle\Controller\Secured\Api;

use AppBundle\Entity\Aksesoris;
use AppBundle\Entity\AksesorisDetail;
use AppBundle\Manager\AksesorisDetailManager;
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
 * @Route("/api/aksesoris-detail", name="app_secured_api_aksesoris_detail")
 */
class AksesorisDetailApiController extends Controller
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
     * @var AksesorisDetailManager
     * @Inject("manager.aksesorisDetail")
     */
    private $aksesorisDetailManager;

    /**
     * @Route("", name="app_secured_api_aksesoris_detail_get", methods={"GET"})
     */
    public function getAction(Request $request)
    {
        $aksesorisDetails = $this->aksesorisDetailManager->findAll();

        return new Response($this->serializer->serialize($aksesorisDetails, 'json',
            SerializationContext::create()->setGroups(['aksesorisDetail'])->enableMaxDepthChecks()));
    }

    /**
     * @Route("/aksesoris/{id}", name="app_secured_api_aksesoris_detail_get_aksesoris", methods={"GET"})
     * @ParamConverter("aksesoris", class="AppBundle:Aksesoris", options={"mapping": {"id": "id"}})
     */
    public function getAksesorisAction(Aksesoris $aksesoris, Request $request)
    {
        $aksesorisDetails = $this->aksesorisDetailManager->findAllByAksesorisId($aksesoris->getId());

        return new Response($this->serializer->serialize($aksesorisDetails, 'json',
            SerializationContext::create()->setGroups(['aksesorisDetail'])->enableMaxDepthChecks()));
    }

    /**
     * @Route("/get-dropdown-aktif", name="app_secured_api_aksesoris_detail_get_dropdown_aktif", methods={"GET"})
     */
    public function getDropdownAllAction(Request $request)
    {
        $aksesorisDetails = $this->aksesorisDetailManager->findAllAktif();

        return new Response($this->serializer->serialize($aksesorisDetails, 'json',
            SerializationContext::create()->setGroups(['dropdown'])->enableMaxDepthChecks()));
    }

    /**
     * @Route("/{id}", name="app_secured_api_aksesoris_detail_delete", methods={"DELETE"})
     * @ParamConverter("aksesorisDetail", class="AppBundle:AksesorisDetail", options={"mapping": {"id": "id"}})
     */
    public function deleteAction(AksesorisDetail $aksesorisDetail, Request $request)
    {
        $response = [
            'result' => 'error',
            'errors' => []
        ];

        $this->aksesorisDetailManager->remove($aksesorisDetail);
        $response['result'] = 'success';

        return new JsonResponse($response);
    }

    /**
     * @Route("/{id}", name="app_secured_api_aksesoris_detail_update", methods={"PUT"})
     * @ParamConverter("aksesorisDetail", class="AppBundle:AksesorisDetail", options={"mapping": {"id": "id"}})
     */
    public function updateAction(AksesorisDetail $aksesorisDetail, Request $request)
    {
        $response = [
            'result'          => 'error',
            'aksesorisDetail' => null,
            'errors'          => []
        ];

        $this->aksesorisDetailManager->assignRequest($aksesorisDetail, $request);

        $errorList = $this->validator->validate($aksesorisDetail, ['Default']);

        if (count($errorList)) {
            foreach ($errorList as $error) {
                /** @var ConstraintViolation $error */
                $response['errors'][$error->getPropertyPath()] = $error->getMessage();
            }
        } else {
            $this->aksesorisDetailManager->save($aksesorisDetail);

            $response['aksesorisDetail'] = json_decode($this->serializer->serialize($aksesorisDetail, 'json',
                SerializationContext::create()->setGroups(['aksesorisDetail'])->enableMaxDepthChecks()));
            $response['result']          = 'success';
        }

        return new JsonResponse($response);
    }

    /**
     * @Route("/{id}", name="app_secured_api_aksesoris_detail_create", methods={"POST"})
     * @ParamConverter("aksesoris", class="AppBundle:Aksesoris", options={"mapping": {"id": "id"}})
     */
    public function createAction(Aksesoris $aksesoris, Request $request)
    {
        $response = [
            'result'          => 'error',
            'aksesorisDetail' => null,
            'errors'          => []
        ];

        $aksesorisDetail = new AksesorisDetail();
        $aksesorisDetail->setAksesoris($aksesoris);

        $this->aksesorisDetailManager->assignRequest($aksesorisDetail, $request);

        $errorList = $this->validator->validate($aksesorisDetail, ['create', 'Default']);

        if (count($errorList)) {
            foreach ($errorList as $error) {
                /** @var ConstraintViolation $error */
                $response['errors'][$error->getPropertyPath()] = $error->getMessage();
            }
        } else {
            $this->aksesorisDetailManager->save($aksesorisDetail);

            $response['aksesorisDetail'] = json_decode($this->serializer->serialize($aksesorisDetail, 'json',
                SerializationContext::create()->setGroups(['aksesorisDetail'])->enableMaxDepthChecks()));
            $response['result']          = 'success';
        }

        return new JsonResponse($response);
    }
}
