<?php

namespace AppBundle\Controller\Secured;

use AppBundle\Entity\Warna;
use AppBundle\Manager\WarnaManager;
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
 * @Route("/warna", name="app_secured_warna")
 */
class WarnaController extends Controller
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
     * @var WarnaManager
     * @Inject("manager.warna")
     */
    private $warnaManager;

    /**
     * @Route("/", name="app_secured_warna_index", methods={"GET"})
     */
    public function indexAction(Request $request)
    {
        return $this->render('AppBundle:Secured/Warna:index.html.twig', []);
    }

    /**
     * @Route("/get", name="app_secured_warna_get")
     */
    public function getAction(Request $request)
    {
        $warnas = $this->warnaManager->findAll();

        return new Response($this->serializer->serialize($warnas, 'json',
            SerializationContext::create()->setGroups(['warna'])->enableMaxDepthChecks()));
    }

    /**
     * @Route("/{id}", name="app_secured_warna_delete", methods={"DELETE"})
     * @ParamConverter("warna", class="AppBundle:Warna", options={"mapping": {"id": "id"}})
     */
    public function deleteAction(Warna $warna, Request $request)
    {
        $response = [
            'result' => 'error',
            'errors' => []
        ];

        $this->warnaManager->remove($warna);
        $response['result'] = 'success';

        return new JsonResponse($response);
    }

    /**
     * @Route("/{id}", name="app_secured_warna_update", methods={"PUT"})
     * @ParamConverter("warna", class="AppBundle:Warna", options={"mapping": {"id": "id"}})
     */
    public function updateAction(Warna $warna, Request $request)
    {
        $response = [
            'result' => 'error',
            'warna'  => null,
            'errors' => []
        ];

        $this->warnaManager->assignRequest($warna, $request);

        $errorList = $this->validator->validate($warna, ['Default']);

        if (count($errorList)) {
            foreach ($errorList as $error) {
                /** @var ConstraintViolation $error */
                $response['errors'][$error->getPropertyPath()] = $error->getMessage();
            }
        } else {
            if (!is_null($warna->getFile())) {
                $uploadableManager = $this->get('stof_doctrine_extensions.uploadable.manager');

                $uploadableManager->markEntityToUpload($warna, $warna->getFile());

                $this->warnaManager->save($warna);

                $this->get('liip_imagine.controller')->filterAction($request, $warna->getWebUrl(),
                    'warna');
                $fileTemporal = new File($this->get('kernel')->getRootDir() . '/../public_html/bahana/media/cache/warna/' . $warna->getWebUrl());
                $fileTemporal->move($warna->getPath(), $warna->getFoto());
            } else {
                $this->warnaManager->save($warna);
            }

            $response['warna']  = json_decode($this->serializer->serialize($warna, 'json',
                SerializationContext::create()->setGroups(['warna'])->enableMaxDepthChecks()));
            $response['result'] = 'success';
        }

        return new JsonResponse($response);
    }

    /**
     * @Route("/", name="app_secured_warna_create", methods={"POST"})
     */
    public function createAction(Request $request)
    {
        $response = [
            'result' => 'error',
            'warna'  => null,
            'errors' => []
        ];

        $warna = new Warna();

        $this->warnaManager->assignRequest($warna, $request);

        $errorList = $this->validator->validate($warna, ['create', 'Default']);

        if (count($errorList)) {
            foreach ($errorList as $error) {
                /** @var ConstraintViolation $error */
                $response['errors'][$error->getPropertyPath()] = $error->getMessage();
            }
        } else {
            if (!is_null($warna->getFile())) {
                $uploadableManager = $this->get('stof_doctrine_extensions.uploadable.manager');

                $uploadableManager->markEntityToUpload($warna, $warna->getFile());

                $this->warnaManager->save($warna);

                $this->get('liip_imagine.controller')->filterAction($request, $warna->getWebUrl(),
                    'warna');
                $fileTemporal = new File($this->get('kernel')->getRootDir() . '/../public_html/bahana/media/cache/warna/' . $warna->getWebUrl());
                $fileTemporal->move($warna->getPath(), $warna->getFoto());
            } else {
                $this->warnaManager->save($warna);
            }

            $response['warna']  = json_decode($this->serializer->serialize($warna, 'json',
                SerializationContext::create()->setGroups(['warna'])->enableMaxDepthChecks()));
            $response['result'] = 'success';
        }

        return new JsonResponse($response);
    }

    /**
     * @Route("/toogle/{id}", name="app_secured_warna_toogle", methods={"POST"})
     * @ParamConverter("warna", class="AppBundle:Warna", options={"mapping": {"id": "id"}})
     */
    public function toogleAction(Warna $warna, Request $request)
    {
        $response = [
            'result' => 'error',
            'warna'  => null,
            'errors' => []
        ];

        $warna->setAktif(!$warna->getAktif());
        $this->warnaManager->save($warna);

        $response['warna']  = json_decode($this->get('serializer')->serialize($warna, 'json',
            SerializationContext::create()->setGroups(['warna'])->enableMaxDepthChecks()));
        $response['result'] = 'success';

        return new JsonResponse($response);
    }
}
