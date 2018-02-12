<?php

namespace AppBundle\Controller\Secured;

use AppBundle\Entity\Artikel;
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
 * @Route("/artikel", name="app_secured_artikel")
 */
class ArtikelController extends Controller
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
     * @Route("/", name="app_secured_artikel_index", methods={"GET"})
     */
    public function indexAction(Request $request)
    {
        return $this->render('AppBundle:Secured/Artikel:index.html.twig', []);
    }

    /**
     * @Route("/get", name="app_secured_artikel_get")
     */
    public function getAction(Request $request)
    {
        $artikels = $this->artikelManager->findAll();

        return new Response($this->serializer->serialize($artikels, 'json',
            SerializationContext::create()->setGroups(['artikel'])->enableMaxDepthChecks()));
    }

    /**
     * @Route("/get-dropdown-all", name="app_secured_artikel_get_dropdown_all")
     */
    public function getDropdownAllAction(Request $request)
    {
        $artikels = $this->artikelManager->findAll();

        return new Response($this->serializer->serialize($artikels, 'json',
            SerializationContext::create()->setGroups(['dropdown'])->enableMaxDepthChecks()));
    }
}
