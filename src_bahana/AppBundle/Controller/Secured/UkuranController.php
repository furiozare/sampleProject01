<?php

namespace AppBundle\Controller\Secured;

use AppBundle\Manager\UkuranManager;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\Serializer\Serializer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator;

/**
 * @Route("/ukuran", name="app_secured_ukuran")
 */
class UkuranController extends Controller
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
     * @var UkuranManager
     * @Inject("manager.ukuran")
     */
    private $ukuranManager;

    /**
     * @Route("/", name="app_secured_ukuran_index", methods={"GET"})
     */
    public function indexAction(Request $request)
    {
        return $this->render('AppBundle:Secured/Ukuran:index.html.twig', []);
    }
}
