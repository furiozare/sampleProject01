<?php

namespace AppBundle\Controller\Secured;

use AppBundle\Manager\KategoriPartManager;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\Serializer\Serializer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator;

/**
 * @Route("/kategori-part", name="app_secured_kategori_part")
 */
class KategoriPartController extends Controller
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
     * @Route("/", name="app_secured_kategori_part_index", methods={"GET"})
     */
    public function indexAction(Request $request)
    {
        return $this->render('AppBundle:Secured/KategoriPart:index.html.twig', []);
    }
}
