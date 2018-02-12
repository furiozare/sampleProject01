<?php

namespace AppBundle\Controller\Secured;

use AppBundle\Entity\Headline;
use AppBundle\Manager\HeadlineManager;
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
 * @Route("/headline", name="app_secured_headline")
 */
class HeadlineController extends Controller
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
     * @var HeadlineManager
     * @Inject("manager.headline")
     */
    private $headlineManager;

    /**
     * @Route("/", name="app_secured_headline_index", methods={"GET"})
     */
    public function indexAction(Request $request)
    {
        return $this->render('AppBundle:Secured/Headline:index.html.twig', []);
    }

    /**
     * @Route("/get", name="app_secured_headline_get")
     */
    public function getAction(Request $request)
    {
        $headlines = $this->headlineManager->findAll();

        return new Response($this->serializer->serialize($headlines, 'json',
            SerializationContext::create()->setGroups(['headline'])->enableMaxDepthChecks()));
    }

    /**
     * @Route("/{id}", name="app_secured_headline_delete", methods={"DELETE"})
     * @ParamConverter("headline", class="AppBundle:Headline", options={"mapping": {"id": "id"}})
     */
    public function deleteAction(Headline $headline, Request $request)
    {
        $response = [
            'result' => 'error',
            'errors' => []
        ];

        $this->headlineManager->remove($headline);
        $response['result'] = 'success';

        return new JsonResponse($response);
    }

    /**
     * @Route("/{id}", name="app_secured_headline_update", methods={"PUT"})
     * @ParamConverter("headline", class="AppBundle:Headline", options={"mapping": {"id": "id"}})
     */
    public function updateAction(Headline $headline, Request $request)
    {
        $response = [
            'result'   => 'error',
            'headline' => null,
            'errors'   => []
        ];

        $this->headlineManager->assignRequest($headline, $request);

        $errorList = $this->validator->validate($headline, ['Default']);

        if (count($errorList)) {
            foreach ($errorList as $error) {
                /** @var ConstraintViolation $error */
                $response['errors'][$error->getPropertyPath()] = $error->getMessage();
            }
        } else {
            if (!is_null($headline->getFile())) {
                $uploadableManager = $this->get('stof_doctrine_extensions.uploadable.manager');

                $uploadableManager->markEntityToUpload($headline, $headline->getFile());
            }

            $this->headlineManager->save($headline);

            $response['headline'] = json_decode($this->serializer->serialize($headline, 'json',
                SerializationContext::create()->setGroups(['headline'])->enableMaxDepthChecks()));
            $response['result']   = 'success';
        }

        return new JsonResponse($response);
    }

    /**
     * @Route("/", name="app_secured_headline_create", methods={"POST"})
     */
    public function createAction(Request $request)
    {
        $response = [
            'result'   => 'error',
            'headline' => null,
            'errors'   => []
        ];

        $headline = new Headline();

        $this->headlineManager->assignRequest($headline, $request);

        $errorList = $this->validator->validate($headline, ['create', 'Default']);

        if (count($errorList)) {
            foreach ($errorList as $error) {
                /** @var ConstraintViolation $error */
                $response['errors'][$error->getPropertyPath()] = $error->getMessage();
            }
        } else {
            $uploadableManager = $this->get('stof_doctrine_extensions.uploadable.manager');

            $uploadableManager->markEntityToUpload($headline, $headline->getFile());

            $this->headlineManager->save($headline);

            $response['headline'] = json_decode($this->serializer->serialize($headline, 'json',
                SerializationContext::create()->setGroups(['headline'])->enableMaxDepthChecks()));
            $response['result']   = 'success';
        }

        return new JsonResponse($response);
    }

    /**
     * @Route("/toogle/{id}", name="app_secured_headline_toogle", methods={"POST"})
     * @ParamConverter("headline", class="AppBundle:Headline", options={"mapping": {"id": "id"}})
     */
    public function toogleAction(Headline $headline, Request $request)
    {
        $response = [
            'result'   => 'error',
            'headline' => null,
            'errors'   => []
        ];

        $headline->setAktif(!$headline->getAktif());
        $this->headlineManager->save($headline);

        $response['headline'] = json_decode($this->get('serializer')->serialize($headline, 'json',
            SerializationContext::create()->setGroups(['headline'])->enableMaxDepthChecks()));
        $response['result']   = 'success';

        return new JsonResponse($response);
    }
}
