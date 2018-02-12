<?php

namespace AppBundle\Controller\Secured\Api;

use AppBundle\Entity\Kendaraan;
use AppBundle\Entity\KendaraanPhoto;
use AppBundle\Manager\KendaraanPhotoManager;
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
 * @Route("/api/kendaraan-photo", name="app_secured_api_kendaraan_photo")
 */
class KendaraanPhotoApiController extends Controller
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
     * @var KendaraanPhotoManager
     * @Inject("manager.kendaraanPhoto")
     */
    private $kendaraanPhotoManager;

    /**
     * @Route("", name="app_secured_api_kendaraan_photo_get", methods={"GET"})
     */
    public function getAction(Request $request)
    {
        $kendaraanPhotos = $this->kendaraanPhotoManager->findAll();

        return new Response($this->serializer->serialize($kendaraanPhotos, 'json',
            SerializationContext::create()->setGroups(['kendaraanPhoto'])->enableMaxDepthChecks()));
    }

    /**
     * @Route("/{id}", name="app_secured_api_kendaraan_photo_get_kendaraan", methods={"GET"})
     * @ParamConverter("kendaraan", class="AppBundle:Kendaraan", options={"mapping": {"id": "id"}})
     */
    public function getKendaraanAction(Kendaraan $kendaraan, Request $request)
    {
        $kendaraanPhotos = $this->kendaraanPhotoManager->findByKendaraanId($kendaraan->getId());

        return new Response($this->serializer->serialize($kendaraanPhotos, 'json',
            SerializationContext::create()->setGroups(['kendaraanPhoto'])->enableMaxDepthChecks()));
    }

    /**
     * @Route("/{id}", name="app_secured_api_kendaraan_photo_delete", methods={"DELETE"})
     * @ParamConverter("kendaraanPhoto", class="AppBundle:KendaraanPhoto", options={"mapping": {"id": "id"}})
     */
    public function deleteAction(KendaraanPhoto $kendaraanPhoto, Request $request)
    {
        $response = [
            'result' => 'error',
            'errors' => []
        ];

        $this->kendaraanPhotoManager->remove($kendaraanPhoto);
        $response['result'] = 'success';

        return new JsonResponse($response);
    }

    /**
     * @Route("", name="app_secured_api_kendaraan_photo_create", methods={"POST"})
     */
    public function createAction(Request $request)
    {
        $response = [
            'result'         => 'error',
            'kendaraanPhoto' => null,
            'errors'         => []
        ];

        $kendaraanPhoto = new KendaraanPhoto();

        $this->kendaraanPhotoManager->assignRequest($kendaraanPhoto, $request);

        $errorList = $this->validator->validate($kendaraanPhoto, ['create', 'Default']);

        if (count($errorList)) {
            foreach ($errorList as $error) {
                /** @var ConstraintViolation $error */
                $response['errors'][$error->getPropertyPath()] = $error->getMessage();
            }
        } else {
            if (!is_null($kendaraanPhoto->getFile())) {
                $uploadableManager = $this->get('stof_doctrine_extensions.uploadable.manager');

                $uploadableManager->markEntityToUpload($kendaraanPhoto, $kendaraanPhoto->getFile());
            }

            $this->kendaraanPhotoManager->save($kendaraanPhoto);

            $response['kendaraanPhoto'] = json_decode($this->serializer->serialize($kendaraanPhoto, 'json',
                SerializationContext::create()->setGroups(['kendaraanPhoto'])->enableMaxDepthChecks()));
            $response['result']         = 'success';
        }

        return new JsonResponse($response);
    }
}
