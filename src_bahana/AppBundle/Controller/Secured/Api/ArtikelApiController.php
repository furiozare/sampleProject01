<?php

namespace AppBundle\Controller\Secured\Api;

use AppBundle\Entity\Artikel;
use AppBundle\Lib\FileUploadLib;
use AppBundle\Manager\ArtikelManager;
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
 * @Route("/api/artikel", name="app_secured_api_artikel")
 */
class ArtikelApiController extends Controller
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
     * @var ArtikelManager
     * @Inject("manager.artikel")
     */
    private $artikelManager;

    /**
     * @Route("", name="app_secured_api_artikel_get", methods={"GET"})
     */
    public function getAction(Request $request)
    {
        $artikels = $this->artikelManager->findAll();

        return new Response($this->serializer->serialize($artikels, 'json',
            SerializationContext::create()->setGroups(['artikel'])->enableMaxDepthChecks()));
    }

    /**
     * @Route("/get-dropdown-all", name="app_secured_api_artikel_get_dropdown_all", methods={"GET"})
     */
    public function getDropdownAllAction(Request $request)
    {
        $artikels = $this->artikelManager->findAll();

        return new Response($this->serializer->serialize($artikels, 'json',
            SerializationContext::create()->setGroups(['dropdown'])->enableMaxDepthChecks()));
    }

    /**
     * @Route("/{id}", name="app_secured_api_artikel_delete", methods={"DELETE"})
     * @ParamConverter("artikel", class="AppBundle:Artikel", options={"mapping": {"id": "id"}})
     */
    public function deleteAction(Artikel $artikel, Request $request)
    {
        $response = [
            'result' => 'error',
            'errors' => []
        ];

        $this->artikelManager->remove($artikel);
        $response['result'] = 'success';

        return new JsonResponse($response);
    }

    /**
     * @Route("/{id}", name="app_secured_api_artikel_update", methods={"PUT"})
     * @ParamConverter("artikel", class="AppBundle:Artikel", options={"mapping": {"id": "id"}})
     */
    public function updateAction(Artikel $artikel, Request $request)
    {
        $response = [
            'result'  => 'error',
            'artikel' => null,
            'errors'  => []
        ];

        $this->artikelManager->assignRequest($artikel, $request);

        $errorList = $this->validator->validate($artikel, ['Default']);

        if (count($errorList)) {
            foreach ($errorList as $error) {
                /** @var ConstraintViolation $error */
                $response['errors'][$error->getPropertyPath()] = $error->getMessage();
            }
        } else {
            if (!is_null($artikel->getFile())) {
                $uploadableManager = $this->get('stof_doctrine_extensions.uploadable.manager');
                $uploadableManager->markEntityToUpload($artikel, $artikel->getFile());

                $this->artikelManager->save($artikel);

                $this->get('liip_imagine.controller')->filterAction($request, $artikel->getWebUrl(),
                    'kategori');
                $fileTemporal = new File(FileUploadLib::GET_PUBLIC_ROOT_DIR() . 'media/cache/kategori/' . $artikel->getWebUrl());
                $fileTemporal->move($artikel->getPath(), $artikel->getFoto());
            } else {
                $this->artikelManager->save($artikel);
            }

            $response['artikel'] = json_decode($this->serializer->serialize($artikel, 'json',
                SerializationContext::create()->setGroups(['artikel'])->enableMaxDepthChecks()));
            $response['result']  = 'success';
        }

        return new JsonResponse($response);
    }

    /**
     * @Route("", name="app_secured_api_artikel_create", methods={"POST"})
     */
    public function createAction(Request $request)
    {
        $response = [
            'result'  => 'error',
            'artikel' => null,
            'errors'  => []
        ];

        $artikel = new Artikel();

        $this->artikelManager->assignRequest($artikel, $request);

        $errorList = $this->validator->validate($artikel, ['create', 'Default']);

        if (count($errorList)) {
            foreach ($errorList as $error) {
                /** @var ConstraintViolation $error */
                $response['errors'][$error->getPropertyPath()] = $error->getMessage();
            }
        } else {
            if (!is_null($artikel->getFile())) {
                $uploadableManager = $this->get('stof_doctrine_extensions.uploadable.manager');
                $uploadableManager->markEntityToUpload($artikel, $artikel->getFile());

                $this->artikelManager->save($artikel);

                $this->get('liip_imagine.controller')->filterAction($request, $artikel->getWebUrl(),
                    'kategori');
                $fileTemporal = new File(FileUploadLib::GET_PUBLIC_ROOT_DIR() . 'media/cache/kategori/' . $artikel->getWebUrl());
                $fileTemporal->move($artikel->getPath(), $artikel->getFoto());
            } else {
                $this->artikelManager->save($artikel);
            }

            $response['artikel'] = json_decode($this->serializer->serialize($artikel, 'json',
                SerializationContext::create()->setGroups(['artikel'])->enableMaxDepthChecks()));
            $response['result']  = 'success';
        }

        return new JsonResponse($response);
    }

    /**
     * @Route("/toogle/{id}", name="app_secured_api_artikel_toogle", methods={"POST"})
     * @ParamConverter("artikel", class="AppBundle:Artikel", options={"mapping": {"id": "id"}})
     */
    public function toogleAction(Artikel $artikel, Request $request)
    {
        $response = [
            'result'  => 'error',
            'artikel' => null,
            'errors'  => []
        ];

        $artikel->setAktif(!$artikel->getAktif());
        $this->artikelManager->save($artikel);

        $response['artikel'] = json_decode($this->get('serializer')->serialize($artikel, 'json',
            SerializationContext::create()->setGroups(['artikel'])->enableMaxDepthChecks()));
        $response['result']  = 'success';

        return new JsonResponse($response);
    }

    /**
     * @Route("/blast/{id}", name="app_secured_api_artikel_blast", methods={"POST"})
     * @ParamConverter("artikel", class="AppBundle:Artikel", options={"mapping": {"id": "id"}})
     */
    public function blastAction(Artikel $artikel, Request $request)
    {
        $response = [
            'result'  => 'error',
            'artikel' => null,
            'errors'  => []
        ];

        $artikel->setMarkForBlast(true);
        $this->artikelManager->save($artikel);

        $response['artikel'] = json_decode($this->get('serializer')->serialize($artikel, 'json',
            SerializationContext::create()->setGroups(['artikel'])->enableMaxDepthChecks()));
        $response['result']  = 'success';

        return new JsonResponse($response);
    }

    /**
     * @Route("/un-blast/{id}", name="app_secured_api_artikel_un_blast", methods={"POST"})
     * @ParamConverter("artikel", class="AppBundle:Artikel", options={"mapping": {"id": "id"}})
     */
    public function unBlastAction(Artikel $artikel, Request $request)
    {
        $response = [
            'result'  => 'error',
            'artikel' => null,
            'errors'  => []
        ];

        $artikel->setMarkForBlast(false);
        $this->artikelManager->save($artikel);

        $response['artikel'] = json_decode($this->get('serializer')->serialize($artikel, 'json',
            SerializationContext::create()->setGroups(['artikel'])->enableMaxDepthChecks()));
        $response['result']  = 'success';

        return new JsonResponse($response);
    }
}
