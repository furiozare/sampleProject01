<?php

namespace AppBundle\Controller\Secured;

use AppBundle\Entity\User;
use AppBundle\Manager\UserManager;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\Serializer\SerializationContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\ConstraintViolation;

/**
 * Class UserController
 *
 * @package AppBundle\Controller\Secured
 *
 * @Route(path="/user", name="app_secured_user")
 */
class UserController extends Controller
{
    /**
     * @var UserManager
     * @Inject("manager.user")
     */
    private $userManager;

    /**
     * @Route(path="/", name="app_secured_user_index", methods={"GET"})
     */
    public function indexAction(Request $request)
    {
        return $this->render('AppBundle:Secured/User:index.html.twig');
    }

    /**
     * @Route(path="/change-password", name="app_secured_user_change_password_post", methods={"POST"})
     */
    public function changePasswordPostAction(Request $request)
    {
        $response = [
            'result' => 'error',
            'errors' => []
        ];

        $params = $request->request->all();

        unset($params['_method']);

        $validator = new Collection([
            'passwordLama'       => [
                new NotBlank(),
                new UserPassword()
            ],
            'passwordBaru'       => new NotBlank(),
            'konfirmasiPassword' => new NotBlank()
        ]);

        $errorList = $this->get('validator')->validate($params, $validator);

        if (count($errorList)) {
            foreach ($errorList as $error) {
                /** @var ConstraintViolation $error */
                $response['errors'][substr($error->getPropertyPath(), 1, -1)] = $error->getMessage();
            }
        } else {
            if (strcmp($params['passwordBaru'], $params['konfirmasiPassword']) != 0) {
                $response['errors']['konfirmasiPassword'] = "Konfirmasi Password harus sesuai dengan Password Baru";
            } else {
                /** @var User $user */
                $user = $this->getUser();
                $this->userManager->encodeNewPassword($user, $params['passwordBaru']);
                $this->userManager->save($user);
                $response['result'] = 'success';
            }
        }

        return new JsonResponse($response);
    }

    /**
     * @Route(path="/get", name="app_secured_user_get")
     */
    public function getAction(Request $request)
    {
        $users = $this->userManager->findAll();

        return new Response($this->get('serializer')->serialize($users, 'json',
            SerializationContext::create()->setGroups(['user'])->enableMaxDepthChecks()));
    }

    /**
     * @Route("/", name="app_secured_user_create", methods={"POST"})
     */
    public function createAction(Request $request)
    {
        $response = [
            'result' => 'error',
            'user'   => null,
            'errors' => []
        ];

        $user = new User();

        $this->userManager->assignRequest($user, $request);

        $user->setPassword($this->getParameter('default_password'));

        $errorList = $this->get('validator')->validate($user, ['create', 'Default']);

        if (count($errorList)) {
            foreach ($errorList as $error) {
                /** @var ConstraintViolation $error */
                $response['errors'][$error->getPropertyPath()] = $error->getMessage();
            }
        } else {
            $user = $this->userManager->encodeNewPassword($user, $user->getPassword());
            $this->userManager->save($user);

            $response['user']   = json_decode($this->get('serializer')->serialize($user, 'json',
                SerializationContext::create()->setGroups(['user'])->enableMaxDepthChecks()));
            $response['result'] = 'success';
        }

        return new JsonResponse($response);
    }

    /**
     * @Route("/reset/{id}", name="app_secured_user_reset", methods={"POST"})
     * @ParamConverter("user", class="AppBundle:User", options={"mapping": {"id": "id"}})
     */
    public function resetAction(User $user, Request $request)
    {
        $response = [
            'result' => 'error',
            'errors' => []
        ];

        $user = $this->userManager->encodeNewPassword($user, $this->getParameter('default_password'));
        $this->userManager->save($user);
        $response['result'] = 'success';

        return new JsonResponse($response);
    }

    /**
     * @Route("/toogle/{id}", name="app_secured_user_toogle", methods={"POST"})
     * @ParamConverter("user", class="AppBundle:User", options={"mapping": {"id": "id"}})
     */
    public function toogleAction(User $user, Request $request)
    {
        $response = [
            'result' => 'error',
            'user'   => null,
            'errors' => []
        ];

        $user->setActive(!$user->getActive());
        $this->userManager->save($user);

        $response['user']   = json_decode($this->get('serializer')->serialize($user, 'json',
            SerializationContext::create()->setGroups(['user'])->enableMaxDepthChecks()));
        $response['result'] = 'success';

        return new JsonResponse($response);
    }
}
