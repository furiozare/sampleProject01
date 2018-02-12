<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Role;
use AppBundle\Entity\User;
use AppBundle\Repository\RoleRepository;
use AppBundle\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\DiExtraBundle\Annotation\InjectParams;
use JMS\DiExtraBundle\Annotation\Service;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * @Service(id="manager.user")
 */
class UserManager
{
    /**
     * @var UserPasswordEncoder
     */
    private $passwordEncoder;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var RoleRepository
     */
    private $roleRepository;

    /**
     * @var SecurityContext
     */
    private $securityContext;

    /**
     * @InjectParams({
     *      "entityManager" = @Inject("doctrine.orm.default_entity_manager"),
     *      "securityContext" = @Inject("security.context"),
     *      "passwordEncoder" = @Inject("security.password_encoder")
     * })
     */
    function __construct(
        EntityManager $entityManager,
        SecurityContext $securityContext,
        UserPasswordEncoder $passwordEncoder
    ) {
        $this->entityManager   = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
        $this->securityContext = $securityContext;

        $this->userRepository = $this->entityManager->getRepository("AppBundle:User");
        $this->roleRepository = $this->entityManager->getRepository("AppBundle:Role");
    }

    public function assignRequest(User $user, Request $request)
    {
        if (!is_null($request->request->get('username'))) {
            $user->setUsername($request->request->get('username'));
        }
        if (!is_null($request->request->get('role'))) {
            $role = $this->roleRepository->queryFindById($request->request->get('role'))->getQuery()->getOneOrNullResult();
            if ($role instanceof Role) {
                $user->setRole($role);
            }
        }
    }

    public function encodeNewPassword(User $user, $newPlainPassword)
    {
        $user->setPassword($this->passwordEncoder->encodePassword($user, $newPlainPassword));

        return $user;
    }

    public function findOneById($id)
    {
        $query = $this->userRepository->queryFindById($id)->getQuery();

        return $query->getOneOrNullResult();
    }

    public function findOneByUsername($username)
    {
        $query = $this->userRepository->queryFindByUsername($username)->getQuery();

        return $query->getOneOrNullResult();
    }

    public function findAll()
    {
        if ($this->securityContext->isGranted('ROLE_SUPER_ADMIN')) {
            $query = $this->userRepository->queryFindAllSuperAdmin()->getQuery();
        } else {
            $query = $this->userRepository->queryFindAll()->getQuery();
        }

        return $query->getResult();
    }

    public function remove(User $user)
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }

    public function save(User $user)
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}
