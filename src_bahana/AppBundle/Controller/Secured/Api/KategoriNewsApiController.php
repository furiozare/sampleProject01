<?php

namespace AppBundle\Controller\Secured\Api;

use AppBundle\Entity\KategoriNews;
use AppBundle\Manager\KategoriNewsManager;
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
 * @Route("/api/kategori-news", name="app_secured_api_kategori_news")
 */
class KategoriNewsApiController extends Controller
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
     * @var KategoriNewsManager
     * @Inject("manager.kategoriNews")
     */
    private $kategoriNewsManager;

    /**
     * @Route("", name="app_secured_api_kategori_news_get", methods={"GET"})
     */
    public function getAction(Request $request)
    {
        $kategoriNewss = $this->kategoriNewsManager->findAll();

        return new Response($this->serializer->serialize($kategoriNewss, 'json',
            SerializationContext::create()->setGroups(['kategoriNews'])->enableMaxDepthChecks()));
    }

    /**
     * @Route("/get-dropdown-all", name="app_secured_api_kategori_news_get_dropdown_all", methods={"GET"})
     */
    public function getDropdownAllAction(Request $request)
    {
        $kategoriNewss = $this->kategoriNewsManager->findAll();

        return new Response($this->serializer->serialize($kategoriNewss, 'json',
            SerializationContext::create()->setGroups(['dropdown'])->enableMaxDepthChecks()));
    }

    /**
     * @Route("/{id}", name="app_secured_api_kategori_news_delete", methods={"DELETE"})
     * @ParamConverter("kategoriNews", class="AppBundle:KategoriNews", options={"mapping": {"id": "id"}})
     */
    public function deleteAction(KategoriNews $kategoriNews, Request $request)
    {
        $response = [
            'result' => 'error',
            'errors' => []
        ];

        $this->kategoriNewsManager->remove($kategoriNews);
        $response['result'] = 'success';

        return new JsonResponse($response);
    }

    /**
     * @Route("/{id}", name="app_secured_api_kategori_news_update", methods={"PUT"})
     * @ParamConverter("kategoriNews", class="AppBundle:KategoriNews", options={"mapping": {"id": "id"}})
     */
    public function updateAction(KategoriNews $kategoriNews, Request $request)
    {
        $response = [
            'result'       => 'error',
            'kategoriNews' => null,
            'errors'       => []
        ];

        $this->kategoriNewsManager->assignRequest($kategoriNews, $request);

        $errorList = $this->validator->validate($kategoriNews, ['Default']);

        if (count($errorList)) {
            foreach ($errorList as $error) {
                /** @var ConstraintViolation $error */
                $response['errors'][$error->getPropertyPath()] = $error->getMessage();
            }
        } else {
            $this->kategoriNewsManager->save($kategoriNews);

            $response['kategoriNews'] = json_decode($this->serializer->serialize($kategoriNews, 'json',
                SerializationContext::create()->setGroups(['kategoriNews'])->enableMaxDepthChecks()));
            $response['result']       = 'success';
        }

        return new JsonResponse($response);
    }

    /**
     * @Route("", name="app_secured_api_kategori_news_create", methods={"POST"})
     */
    public function createAction(Request $request)
    {
        $response = [
            'result'       => 'error',
            'kategoriNews' => null,
            'errors'       => []
        ];

        $kategoriNews = new KategoriNews();

        $this->kategoriNewsManager->assignRequest($kategoriNews, $request);

        $errorList = $this->validator->validate($kategoriNews, ['create', 'Default']);

        if (count($errorList)) {
            foreach ($errorList as $error) {
                /** @var ConstraintViolation $error */
                $response['errors'][$error->getPropertyPath()] = $error->getMessage();
            }
        } else {
            $this->kategoriNewsManager->save($kategoriNews);

            $response['kategoriNews'] = json_decode($this->serializer->serialize($kategoriNews, 'json',
                SerializationContext::create()->setGroups(['kategoriNews'])->enableMaxDepthChecks()));
            $response['result']       = 'success';
        }

        return new JsonResponse($response);
    }

    /**
     * @Route("/toogle/{id}", name="app_secured_api_kategori_news_toogle", methods={"POST"})
     * @ParamConverter("kategoriNews", class="AppBundle:KategoriNews", options={"mapping": {"id": "id"}})
     */
    public function toogleAction(KategoriNews $kategoriNews, Request $request)
    {
        $response = [
            'result'       => 'error',
            'kategoriNews' => null,
            'errors'       => []
        ];

        $kategoriNews->setAktif(!$kategoriNews->getAktif());
        $this->kategoriNewsManager->save($kategoriNews);

        $response['kategoriNews'] = json_decode($this->get('serializer')->serialize($kategoriNews, 'json',
            SerializationContext::create()->setGroups(['kategoriNews'])->enableMaxDepthChecks()));
        $response['result']       = 'success';

        return new JsonResponse($response);
    }
}
