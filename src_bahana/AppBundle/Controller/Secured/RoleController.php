<?php

namespace AppBundle\Controller\Secured;

use AppBundle\Manager\RoleManager;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\Serializer\SerializationContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class RoleController
 *
 * @package AppBundle\Controller\Secured
 *
 * @Route(path="/role", name="app_secured_role")
 */
class RoleController extends Controller
{
    /**
     * @var RoleManager
     * @Inject("manager.role")
     */
    private $roleManager;

    /**
     * @Route(path="/get", name="app_secured_role_get")
     */
    public function getAction(Request $request)
    {
        $roles = $this->roleManager->findAll();

        return new Response($this->get('serializer')->serialize($roles, 'json',
            SerializationContext::create()->setGroups(['role'])->enableMaxDepthChecks()));
    }
}
