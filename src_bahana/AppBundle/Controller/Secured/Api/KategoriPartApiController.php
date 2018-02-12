<?php

namespace AppBundle\Controller\Secured\Api;

use AppBundle\Entity\KategoriPart;
use AppBundle\Manager\KategoriPartManager;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator;

/**
 * @Route("/api/kategori-part", name="app_secured_api_kategori_part")
 */
class KategoriPartApiController extends Controller
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
     * @var KategoriPartManager
     * @Inject("manager.kategoriPart")
     */
    private $kategoriPartManager;

    /**
     * @Route("", name="app_secured_api_kategori_part_get", methods={"GET"})
     */
    public function getAction(Request $request)
    {
        $kategoriParts = $this->kategoriPartManager->findAll();

        return new Response($this->serializer->serialize($kategoriParts, 'json',
            SerializationContext::create()->setGroups(['kategoriPart'])->enableMaxDepthChecks()));
    }

    /**
     * @Route("/get-dropdown-aktif", name="app_secured_api_kategori_part_get_dropdown_aktif", methods={"GET"})
     */
    public function getDropdownAllAction(Request $request)
    {
        $kategoriParts = $this->kategoriPartManager->findAllAktif();

        return new Response($this->serializer->serialize($kategoriParts, 'json',
            SerializationContext::create()->setGroups(['dropdown'])->enableMaxDepthChecks()));
    }

    /**
     * @Route("/{id}", name="app_secured_api_kategori_part_delete", methods={"DELETE"})
     * @ParamConverter("kategoriPart", class="AppBundle:KategoriPart", options={"mapping": {"id": "id"}})
     */
    public function deleteAction(KategoriPart $kategoriPart, Request $request)
    {
        $response = [
            'result' => 'error',
            'errors' => []
        ];

        $this->kategoriPartManager->remove($kategoriPart);
        $response['result'] = 'success';

        return new JsonResponse($response);
    }

    /**
     * @Route("/{id}", name="app_secured_api_kategori_part_update", methods={"PUT"})
     * @ParamConverter("kategoriPart", class="AppBundle:KategoriPart", options={"mapping": {"id": "id"}})
     */
    public function updateAction(KategoriPart $kategoriPart, Request $request)
    {
        $response = [
            'result'       => 'error',
            'kategoriPart' => null,
            'errors'       => []
        ];

        $this->kategoriPartManager->assignRequest($kategoriPart, $request);

        $errorList = $this->validator->validate($kategoriPart, ['Default']);

        if (count($errorList)) {
            foreach ($errorList as $error) {
                /** @var ConstraintViolation $error */
                $response['errors'][$error->getPropertyPath()] = $error->getMessage();
            }
        } else {
            if (!is_null($kategoriPart->getFile())) {
                $uploadableManager = $this->get('stof_doctrine_extensions.uploadable.manager');

                $uploadableManager->markEntityToUpload($kategoriPart, $kategoriPart->getFile());

                $this->kategoriPartManager->save($kategoriPart);

                $this->get('liip_imagine.controller')->filterAction($request, $kategoriPart->getWebUrl(),
                    'kategori');
                $fileTemporal = new File($this->get('kernel')->getRootDir() . '/../public_html/bahana/media/cache/kategori/' . $kategoriPart->getWebUrl());
                $fileTemporal->move($kategoriPart->getPath(), $kategoriPart->getFoto());
            } else {
                $this->kategoriPartManager->save($kategoriPart);
            }

            $response['kategoriPart'] = json_decode($this->serializer->serialize($kategoriPart, 'json',
                SerializationContext::create()->setGroups(['kategoriPart'])->enableMaxDepthChecks()));
            $response['result']       = 'success';
        }

        return new JsonResponse($response);
    }

    /**
     * @Route("", name="app_secured_api_kategori_part_create", methods={"POST"})
     */
    public function createAction(Request $request)
    {
        $response = [
            'result'       => 'error',
            'kategoriPart' => null,
            'errors'       => []
        ];

        $kategoriPart = new KategoriPart();

        $this->kategoriPartManager->assignRequest($kategoriPart, $request);

        $errorList = $this->validator->validate($kategoriPart, ['create', 'Default']);

        if (count($errorList)) {
            foreach ($errorList as $error) {
                /** @var ConstraintViolation $error */
                $response['errors'][$error->getPropertyPath()] = $error->getMessage();
            }
        } else {
            if (!is_null($kategoriPart->getFile())) {
                $uploadableManager = $this->get('stof_doctrine_extensions.uploadable.manager');

                $uploadableManager->markEntityToUpload($kategoriPart, $kategoriPart->getFile());

                $this->kategoriPartManager->save($kategoriPart);

                $this->get('liip_imagine.controller')->filterAction($request, $kategoriPart->getWebUrl(),
                    'kategori');
                $fileTemporal = new File($this->get('kernel')->getRootDir() . '/../public_html/bahana/media/cache/kategori/' . $kategoriPart->getWebUrl());
                $fileTemporal->move($kategoriPart->getPath(), $kategoriPart->getFoto());
            } else {
                $this->kategoriPartManager->save($kategoriPart);
            }

            $response['kategoriPart'] = json_decode($this->serializer->serialize($kategoriPart, 'json',
                SerializationContext::create()->setGroups(['kategoriPart'])->enableMaxDepthChecks()));
            $response['result']       = 'success';
        }

        return new JsonResponse($response);
    }

    /**
     * @Route("/toogle/{id}", name="app_secured_api_kategori_part_toogle", methods={"POST"})
     * @ParamConverter("kategoriPart", class="AppBundle:KategoriPart", options={"mapping": {"id": "id"}})
     */
    public function toogleAction(KategoriPart $kategoriPart, Request $request)
    {
        $response = [
            'result'       => 'error',
            'kategoriPart' => null,
            'errors'       => []
        ];

        $kategoriPart->setAktif(!$kategoriPart->getAktif());
        $this->kategoriPartManager->save($kategoriPart);

        $response['kategoriPart'] = json_decode($this->get('serializer')->serialize($kategoriPart, 'json',
            SerializationContext::create()->setGroups(['kategoriPart'])->enableMaxDepthChecks()));
        $response['result']       = 'success';

        return new JsonResponse($response);
    }
}
