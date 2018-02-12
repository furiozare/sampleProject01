<?php

namespace AppBundle\Controller\Secured;

use AppBundle\Manager\HargaOTRManager;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\Serializer\Serializer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator;

/**
 * @Route("/harga-otr", name="app_secured_harga_otr")
 */
class HargaOTRController extends Controller
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
     * @var HargaOTRManager
     * @Inject("manager.hargaOTR")
     */
    private $hargaOTRManager;

    /**
     * @Route("/", name="app_secured_harga_otr_index", methods={"GET"})
     */
    public function indexAction(Request $request)
    {
        return $this->render('AppBundle:Secured/HargaOTR:index.html.twig', []);
    }
}
