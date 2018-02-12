<?php

namespace AppBundle\Controller\Secured\Api;

use AppBundle\Entity\Part;
use AppBundle\Entity\PartPhoto;
use AppBundle\Manager\PartPhotoManager;
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
 * @Route("/api/part-photo", name="app_secured_api_part_photo")
 */
class PartPhotoApiController extends Controller
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
     * @var PartPhotoManager
     * @Inject("manager.partPhoto")
     */
    private $partPhotoManager;

    /**
     * @Route("", name="app_secured_api_part_photo_get", methods={"GET"})
     */
    public function getAction(Request $request)
    {
        $partPhotos = $this->partPhotoManager->findAll();

        return new Response($this->serializer->serialize($partPhotos, 'json',
            SerializationContext::create()->setGroups(['partPhoto'])->enableMaxDepthChecks()));
    }

    /**
     * @Route("/part/{id}", name="app_secured_api_part_photo_get_part", methods={"GET"})
     * @ParamConverter("part", class="AppBundle:Part", options={"mapping": {"id": "id"}})
     */
    public function getPartAction(Part $part, Request $request)
    {
        $partPhotos = $this->partPhotoManager->findAllByPartId($part->getId());

        return new Response($this->serializer->serialize($partPhotos, 'json',
            SerializationContext::create()->setGroups(['partPhoto'])->enableMaxDepthChecks()));
    }

    /**
     * @Route("/get-dropdown-aktif", name="app_secured_api_part_photo_get_dropdown_aktif", methods={"GET"})
     */
    public function getDropdownAllAction(Request $request)
    {
        $partPhotos = $this->partPhotoManager->findAll();

        return new Response($this->serializer->serialize($partPhotos, 'json',
            SerializationContext::create()->setGroups(['dropdown'])->enableMaxDepthChecks()));
    }

    /**
     * @Route("/{id}", name="app_secured_api_part_photo_delete", methods={"DELETE"})
     * @ParamConverter("partPhoto", class="AppBundle:PartPhoto", options={"mapping": {"id": "id"}})
     */
    public function deleteAction(PartPhoto $partPhoto, Request $request)
    {
        $response = [
            'result' => 'error',
            'errors' => []
        ];

        $this->partPhotoManager->remove($partPhoto);
        $response['result'] = 'success';

        return new JsonResponse($response);
    }

    /**
     * @Route("/{id}", name="app_secured_api_part_photo_create", methods={"POST"})
     * @ParamConverter("part", class="AppBundle:Part", options={"mapping": {"id": "id"}})
     */
    public function createAction(Part $part, Request $request)
    {
        $response = [
            'result'    => 'error',
            'partPhoto' => null,
            'errors'    => []
        ];

        $partPhoto = new PartPhoto();
        $partPhoto->setPart($part);

        $this->partPhotoManager->assignRequest($partPhoto, $request);

        $errorList = $this->validator->validate($partPhoto, ['create', 'Default']);

        if (count($errorList)) {
            foreach ($errorList as $error) {
                /** @var ConstraintViolation $error */
                $response['errors'][$error->getPropertyPath()] = $error->getMessage();
            }
        } else {
            if (!is_null($partPhoto->getFile())) {
                $uploadableManager = $this->get('stof_doctrine_extensions.uploadable.manager');

                $uploadableManager->markEntityToUpload($partPhoto, $partPhoto->getFile());
            }
            $this->partPhotoManager->save($partPhoto);

            $response['partPhoto'] = json_decode($this->serializer->serialize($partPhoto, 'json',
                SerializationContext::create()->setGroups(['partPhoto'])->enableMaxDepthChecks()));
            $response['result']    = 'success';
        }

        return new JsonResponse($response);
    }
}
