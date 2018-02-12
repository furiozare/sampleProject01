<?php

namespace AppBundle\Controller\Secured\Api;

use AppBundle\Entity\Kategori;
use AppBundle\Manager\KategoriManager;
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
 * @Route("/api/kategori", name="app_secured_api_kategori")
 */
class KategoriApiController extends Controller
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
     * @var KategoriManager
     * @Inject("manager.kategori")
     */
    private $kategoriManager;

    /**
     * @Route("", name="app_secured_api_kategori_get", methods={"GET"})
     */
    public function getAction(Request $request)
    {
        $kategoris = $this->kategoriManager->findAll();

        return new Response($this->serializer->serialize($kategoris, 'json',
            SerializationContext::create()->setGroups(['kategori'])->enableMaxDepthChecks()));
    }

    /**
     * @Route("/get-dropdown-all", name="app_secured_api_kategori_get_dropdown_all", methods={"GET"})
     */
    public function getDropdownAllAction(Request $request)
    {
        $kategoris = $this->kategoriManager->findAll();

        return new Response($this->serializer->serialize($kategoris, 'json',
            SerializationContext::create()->setGroups(['dropdown'])->enableMaxDepthChecks()));
    }

    /**
     * @Route("/{id}", name="app_secured_api_kategori_delete", methods={"DELETE"})
     * @ParamConverter("kategori", class="AppBundle:Kategori", options={"mapping": {"id": "id"}})
     */
    public function deleteAction(Kategori $kategori, Request $request)
    {
        $response = [
            'result' => 'error',
            'errors' => []
        ];

        $this->kategoriManager->remove($kategori);
        $response['result'] = 'success';

        return new JsonResponse($response);
    }

    /**
     * @Route("/{id}", name="app_secured_api_kategori_update", methods={"PUT"})
     * @ParamConverter("kategori", class="AppBundle:Kategori", options={"mapping": {"id": "id"}})
     */
    public function updateAction(Kategori $kategori, Request $request)
    {
        $response = [
            'result'   => 'error',
            'kategori' => null,
            'errors'   => []
        ];

        $this->kategoriManager->assignRequest($kategori, $request);

        $errorList = $this->validator->validate($kategori, ['Default']);

        if (count($errorList)) {
            foreach ($errorList as $error) {
                /** @var ConstraintViolation $error */
                $response['errors'][$error->getPropertyPath()] = $error->getMessage();
            }
        } else {
            if (!is_null($kategori->getFile())) {
                $uploadableManager = $this->get('stof_doctrine_extensions.uploadable.manager');

                $uploadableManager->markEntityToUpload($kategori, $kategori->getFile());

                $this->kategoriManager->save($kategori);

                $this->get('liip_imagine.controller')->filterAction($request, $kategori->getWebUrl(),
                    'kategori');
                $fileTemporal = new File($this->get('kernel')->getRootDir() . '/../public_html/media/cache/kategori/' . $kategori->getWebUrl());
                $fileTemporal->move($kategori->getPath(), $kategori->getFoto());
            } else {
                $this->kategoriManager->save($kategori);
            }

            $response['kategori'] = json_decode($this->serializer->serialize($kategori, 'json',
                SerializationContext::create()->setGroups(['kategori'])->enableMaxDepthChecks()));
            $response['result']   = 'success';
        }

        return new JsonResponse($response);
    }

    /**
     * @Route("", name="app_secured_api_kategori_create", methods={"POST"})
     */
    public function createAction(Request $request)
    {
        $response = [
            'result'   => 'error',
            'kategori' => null,
            'errors'   => []
        ];

        $kategori = new Kategori();

        $this->kategoriManager->assignRequest($kategori, $request);

        $errorList = $this->validator->validate($kategori, ['create', 'Default']);

        if (count($errorList)) {
            foreach ($errorList as $error) {
                /** @var ConstraintViolation $error */
                $response['errors'][$error->getPropertyPath()] = $error->getMessage();
            }
        } else {
            if (!is_null($kategori->getFile())) {
                $uploadableManager = $this->get('stof_doctrine_extensions.uploadable.manager');

                $uploadableManager->markEntityToUpload($kategori, $kategori->getFile());

                $this->kategoriManager->save($kategori);

                $this->get('liip_imagine.controller')->filterAction($request, $kategori->getWebUrl(),
                    'kategori');
                $fileTemporal = new File($this->get('kernel')->getRootDir() . '/../public_html/media/cache/kategori/' . $kategori->getWebUrl());
                $fileTemporal->move($kategori->getPath(), $kategori->getFoto());
            } else {
                $this->kategoriManager->save($kategori);
            }

            $response['kategori'] = json_decode($this->serializer->serialize($kategori, 'json',
                SerializationContext::create()->setGroups(['kategori'])->enableMaxDepthChecks()));
            $response['result']   = 'success';
        }

        return new JsonResponse($response);
    }

    /**
     * @Route("/toogle/{id}", name="app_secured_api_kategori_toogle", methods={"POST"})
     * @ParamConverter("kategori", class="AppBundle:Kategori", options={"mapping": {"id": "id"}})
     */
    public function toogleAction(Kategori $kategori, Request $request)
    {
        $response = [
            'result'   => 'error',
            'kategori' => null,
            'errors'   => []
        ];

        $kategori->setAktif(!$kategori->getAktif());
        $this->kategoriManager->save($kategori);

        $response['kategori'] = json_decode($this->get('serializer')->serialize($kategori, 'json',
            SerializationContext::create()->setGroups(['kategori'])->enableMaxDepthChecks()));
        $response['result']   = 'success';

        return new JsonResponse($response);
    }
}
