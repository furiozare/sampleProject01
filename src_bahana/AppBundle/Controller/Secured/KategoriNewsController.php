<?php

namespace AppBundle\Controller\Secured;

use AppBundle\Entity\KategoriNews;
use AppBundle\Manager\KategoriNewsManager;
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
 * @Route("/kategori-news", name="app_secured_kategori_news")
 */
class KategoriNewsController extends Controller
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
     * @Route("/", name="app_secured_kategori_news_index", methods={"GET"})
     */
    public function indexAction(Request $request)
    {
        return $this->render('AppBundle:Secured/KategoriNews:index.html.twig', []);
    }

    /**
     * @Route("/get", name="app_secured_kategori_news_get")
     */
    public function getAction(Request $request)
    {
        $kategoriNewss = $this->kategoriNewsManager->findAll();

        return new Response($this->serializer->serialize($kategoriNewss, 'json',
            SerializationContext::create()->setGroups(['kategoriNews'])->enableMaxDepthChecks()));
    }

    /**
     * @Route("/get-dropdown-all", name="app_secured_kategori_news_get_dropdown_all")
     */
    public function getDropdownAllAction(Request $request)
    {
        $kategoriNewss = $this->kategoriNewsManager->findAll();

        return new Response($this->serializer->serialize($kategoriNewss, 'json',
            SerializationContext::create()->setGroups(['dropdown'])->enableMaxDepthChecks()));
    }
}
