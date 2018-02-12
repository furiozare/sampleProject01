<?php

namespace AppBundle\Controller\Secured;

use AppBundle\Entity\Kendaraan;
use AppBundle\Manager\KendaraanManager;
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
 * @Route("/kendaraan", name="app_secured_kendaraan")
 */
class KendaraanController extends Controller
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
     * @var KendaraanManager
     * @Inject("manager.kendaraan")
     */
    private $kendaraanManager;

    /**
     * @Route("/", name="app_secured_kendaraan_index", methods={"GET"})
     */
    public function indexAction(Request $request)
    {
        return $this->render('AppBundle:Secured/Kendaraan:index.html.twig', []);
    }

    /**
     * @Route("/get", name="app_secured_kendaraan_get")
     */
    public function getAction(Request $request)
    {
        $kendaraans = $this->kendaraanManager->findAll();

        return new Response($this->serializer->serialize($kendaraans, 'json',
            SerializationContext::create()->setGroups(['kendaraan'])->enableMaxDepthChecks()));
    }

    /**
     * @Route("/{id}", name="app_secured_kendaraan_delete", methods={"DELETE"})
     * @ParamConverter("kendaraan", class="AppBundle:Kendaraan", options={"mapping": {"id": "id"}})
     */
    public function deleteAction(Kendaraan $kendaraan, Request $request)
    {
        $response = [
            'result' => 'error',
            'errors' => []
        ];

        $this->kendaraanManager->remove($kendaraan);
        $response['result'] = 'success';

        return new JsonResponse($response);
    }

    /**
     * @Route("/{id}", name="app_secured_kendaraan_update", methods={"PUT"})
     * @ParamConverter("kendaraan", class="AppBundle:Kendaraan", options={"mapping": {"id": "id"}})
     */
    public function updateAction(Kendaraan $kendaraan, Request $request)
    {
        $response = [
            'result'    => 'error',
            'kendaraan' => null,
            'errors'    => []
        ];

        $this->kendaraanManager->assignRequest($kendaraan, $request);

        $errorList = $this->validator->validate($kendaraan, ['Default']);

        if (count($errorList)) {
            foreach ($errorList as $error) {
                /** @var ConstraintViolation $error */
                $response['errors'][$error->getPropertyPath()] = $error->getMessage();
            }
        } else {
            $this->kendaraanManager->save($kendaraan);

            $response['kendaraan'] = json_decode($this->serializer->serialize($kendaraan, 'json',
                SerializationContext::create()->setGroups(['kendaraan'])->enableMaxDepthChecks()));
            $response['result']    = 'success';
        }

        return new JsonResponse($response);
    }

    /**
     * @Route("/{id}/spec", name="app_secured_kendaraan_update_specification", methods={"PUT"})
     * @ParamConverter("kendaraan", class="AppBundle:Kendaraan", options={"mapping": {"id": "id"}})
     */
    public function updateSpecificationAction(Kendaraan $kendaraan, Request $request)
    {
        $response = [
            'result'    => 'error',
            'kendaraan' => null,
            'errors'    => []
        ];

        $this->kendaraanManager->assignRequestSpecification($kendaraan, $request);

        $errorList = $this->validator->validate($kendaraan, ['Default']);

        if (count($errorList)) {
            foreach ($errorList as $error) {
                /** @var ConstraintViolation $error */
                $response['errors'][$error->getPropertyPath()] = $error->getMessage();
            }
        } else {
            $this->kendaraanManager->save($kendaraan);

            $response['kendaraan'] = json_decode($this->serializer->serialize($kendaraan, 'json',
                SerializationContext::create()->setGroups(['kendaraan'])->enableMaxDepthChecks()));
            $response['result']    = 'success';
        }

        return new JsonResponse($response);
    }

    /**
     * @Route("/", name="app_secured_kendaraan_create", methods={"POST"})
     */
    public function createAction(Request $request)
    {
        $response = [
            'result'    => 'error',
            'kendaraan' => null,
            'errors'    => []
        ];

        $kendaraan = new Kendaraan();

        $this->kendaraanManager->assignRequest($kendaraan, $request);

        $errorList = $this->validator->validate($kendaraan, ['create', 'Default']);

        if (count($errorList)) {
            foreach ($errorList as $error) {
                /** @var ConstraintViolation $error */
                $response['errors'][$error->getPropertyPath()] = $error->getMessage();
            }
        } else {
            $this->kendaraanManager->save($kendaraan);

            $response['kendaraan'] = json_decode($this->serializer->serialize($kendaraan, 'json',
                SerializationContext::create()->setGroups(['kendaraan'])->enableMaxDepthChecks()));
            $response['result']    = 'success';
        }

        return new JsonResponse($response);
    }

    /**
     * @Route("/toogle/{id}", name="app_secured_kendaraan_toogle", methods={"POST"})
     * @ParamConverter("kendaraan", class="AppBundle:Kendaraan", options={"mapping": {"id": "id"}})
     */
    public function toogleAction(Kendaraan $kendaraan, Request $request)
    {
        $response = [
            'result'    => 'error',
            'kendaraan' => null,
            'errors'    => []
        ];

        $kendaraan->setAktif(!$kendaraan->getAktif());
        $this->kendaraanManager->save($kendaraan);

        $response['kendaraan'] = json_decode($this->get('serializer')->serialize($kendaraan, 'json',
            SerializationContext::create()->setGroups(['kendaraan'])->enableMaxDepthChecks()));
        $response['result']    = 'success';

        return new JsonResponse($response);
    }
}
