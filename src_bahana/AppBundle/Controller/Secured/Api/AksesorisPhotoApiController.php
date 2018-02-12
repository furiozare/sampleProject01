<?php

namespace AppBundle\Controller\Secured\Api;

use AppBundle\Entity\Aksesoris;
use AppBundle\Entity\AksesorisPhoto;
use AppBundle\Manager\AksesorisPhotoManager;
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
 * @Route("/api/aksesoris-photo", name="app_secured_api_aksesoris_photo")
 */
class AksesorisPhotoApiController extends Controller
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
     * @var AksesorisPhotoManager
     * @Inject("manager.aksesorisPhoto")
     */
    private $aksesorisPhotoManager;

    /**
     * @Route("", name="app_secured_api_aksesoris_photo_get", methods={"GET"})
     */
    public function getAction(Request $request)
    {
        $aksesorisPhotos = $this->aksesorisPhotoManager->findAll();

        return new Response($this->serializer->serialize($aksesorisPhotos, 'json',
            SerializationContext::create()->setGroups(['aksesorisPhoto'])->enableMaxDepthChecks()));
    }

    /**
     * @Route("/aksesoris/{id}", name="app_secured_api_aksesoris_photo_get_aksesoris", methods={"GET"})
     * @ParamConverter("aksesoris", class="AppBundle:Aksesoris", options={"mapping": {"id": "id"}})
     */
    public function getAksesorisAction(Aksesoris $aksesoris, Request $request)
    {
        $aksesorisPhotos = $this->aksesorisPhotoManager->findAllByAksesorisId($aksesoris->getId());

        return new Response($this->serializer->serialize($aksesorisPhotos, 'json',
            SerializationContext::create()->setGroups(['aksesorisPhoto'])->enableMaxDepthChecks()));
    }

    /**
     * @Route("/get-dropdown-aktif", name="app_secured_api_aksesoris_photo_get_dropdown_aktif", methods={"GET"})
     */
    public function getDropdownAllAction(Request $request)
    {
        $aksesorisPhotos = $this->aksesorisPhotoManager->findAllAktif();

        return new Response($this->serializer->serialize($aksesorisPhotos, 'json',
            SerializationContext::create()->setGroups(['dropdown'])->enableMaxDepthChecks()));
    }

    /**
     * @Route("/{id}", name="app_secured_api_aksesoris_photo_delete", methods={"DELETE"})
     * @ParamConverter("aksesorisPhoto", class="AppBundle:AksesorisPhoto", options={"mapping": {"id": "id"}})
     */
    public function deleteAction(AksesorisPhoto $aksesorisPhoto, Request $request)
    {
        $response = [
            'result' => 'error',
            'errors' => []
        ];

        $this->aksesorisPhotoManager->remove($aksesorisPhoto);
        $response['result'] = 'success';

        return new JsonResponse($response);
    }

    /**
     * @Route("/{id}", name="app_secured_api_aksesoris_photo_create", methods={"POST"})
     * @ParamConverter("aksesoris", class="AppBundle:Aksesoris", options={"mapping": {"id": "id"}})
     */
    public function createAction(Aksesoris $aksesoris, Request $request)
    {
        $response = [
            'result'         => 'error',
            'aksesorisPhoto' => null,
            'errors'         => []
        ];

        $aksesorisPhoto = new AksesorisPhoto();
        $aksesorisPhoto->setAksesoris($aksesoris);

        $this->aksesorisPhotoManager->assignRequest($aksesorisPhoto, $request);

        $errorList = $this->validator->validate($aksesorisPhoto, ['create', 'Default']);

        if (count($errorList)) {
            foreach ($errorList as $error) {
                /** @var ConstraintViolation $error */
                $response['errors'][$error->getPropertyPath()] = $error->getMessage();
            }
        } else {
            if (!is_null($aksesorisPhoto->getFile())) {
                $uploadableManager = $this->get('stof_doctrine_extensions.uploadable.manager');

                $uploadableManager->markEntityToUpload($aksesorisPhoto, $aksesorisPhoto->getFile());
            }
            $this->aksesorisPhotoManager->save($aksesorisPhoto);

            $response['aksesorisPhoto'] = json_decode($this->serializer->serialize($aksesorisPhoto, 'json',
                SerializationContext::create()->setGroups(['aksesorisPhoto'])->enableMaxDepthChecks()));
            $response['result']         = 'success';
        }

        return new JsonResponse($response);
    }
}
