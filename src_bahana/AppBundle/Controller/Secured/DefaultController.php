<?php

namespace AppBundle\Controller\Secured;

use AppBundle\Entity\Role;
use AppBundle\Entity\User;
use AppBundle\Manager\RoleManager;
use AppBundle\Manager\UserManager;
use JMS\DiExtraBundle\Annotation\Inject;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DefaultController
 *
 * @package AppBundle\Controller\Secured
 *
 * @Route(path="/", name="app_secured_default")
 */
class DefaultController extends Controller
{
    /**
     * @var UserManager
     * @Inject("manager.user")
     */
    private $userManager;

    /**
     * @var RoleManager
     * @Inject("manager.role")
     */
    private $roleManager;

    /**
     * @Route(path="/", name="app_secured_default_dashboard")
     */
    public function dashboardAction(Request $request)
    {
        return $this->render('AppBundle:Secured/Default:dashboard.html.twig');
    }

    /**
     * @Route("/login", name="app_default_login")
     */
    public function loginAction(Request $request)
    {
        $superAdmin = $this->roleManager->findOneBySymName('ROLE_SUPER_ADMIN');
        if (!$superAdmin instanceof Role) {
            $superAdmin = new Role();
            $superAdmin->setSymName('ROLE_SUPER_ADMIN');
            $superAdmin->setName('Super Administrator');
        }
        $superAdmin->setPublish(0);
        $this->roleManager->save($superAdmin);

        $admin = $this->roleManager->findOneBySymName('ROLE_ADMIN');
        if (!$admin instanceof Role) {
            $admin = new Role();
            $admin->setSymName('ROLE_ADMIN');
            $admin->setName('Administrator');
        }
        $admin->setPublish(1);
        $this->roleManager->save($admin);

        $han = $this->userManager->findOneByUsername('han');
        if (!$han instanceof User) {
            $han = new User();
            $han->setUsername('han');
        }
        $han->setRole($superAdmin);
        $han = $this->userManager->encodeNewPassword($han, 'admin');
        $this->userManager->save($han);

        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            'AppBundle:Secured/Default:login.html.twig',
            [
                // last username entered by the user
                'last_username' => $lastUsername,
                'error'         => $error,
            ]
        );
    }

    /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheckAction()
    {
        // this controller will not be executed,
        // as the route is handled by the Security system
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
        // this controller will not be executed,
        // as the route is handled by the Security system
    }
}
