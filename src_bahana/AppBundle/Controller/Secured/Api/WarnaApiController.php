<?php

namespace AppBundle\Controller\Secured\Api;

use AppBundle\Manager\WarnaManager;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator;

/**
 * @Route("/api/warna", name="app_secured_api_warna")
 */
class WarnaApiController extends Controller
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
     * @Route("", name="app_secured_api_warna_get", methods={"GET"})
     */
    public function getAction(Request $request)
    {
        $warnas = $this->warnaManager->findAll();

        return new Response($this->serializer->serialize($warnas, 'json',
            SerializationContext::create()->setGroups(['warna'])->enableMaxDepthChecks()));
    }

    /**
     * @Route("/get-dropdown-aktif", name="app_secured_api_warna_get_dropdown_aktif", methods={"GET"})
     */
    public function getDropdownAktifAction(Request $request)
    {
        $warnas = $this->warnaManager->findAllAktif();

        return new Response($this->serializer->serialize($warnas, 'json',
            SerializationContext::create()->setGroups(['dropdown'])->enableMaxDepthChecks()));
    }
}
