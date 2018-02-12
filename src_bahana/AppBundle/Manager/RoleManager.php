<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Role;
use AppBundle\Repository\RoleRepository;
use Doctrine\ORM\EntityManager;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\DiExtraBundle\Annotation\InjectParams;
use JMS\DiExtraBundle\Annotation\Service;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * @Service(id="manager.role")
 */
class RoleManager
{
    /**
     * @var EntityManager
     */
    private $entityManager;

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
     *      "securityContext" = @Inject("security.context")
     * })
     */
    function __construct(EntityManager $entityManager, SecurityContext $securityContext)
    {
        $this->entityManager   = $entityManager;
        $this->securityContext = $securityContext;

        $this->roleRepository = $this->entityManager->getRepository("AppBundle:Role");
    }

    public function findAll()
    {
        if ($this->securityContext->isGranted('ROLE_SUPER_ADMIN')) {
            $query = $this->roleRepository->queryFindAllSuperAdmin()->getQuery();
        } else {
            $query = $this->roleRepository->queryFindAll()->getQuery();
        }

        return $query->getResult();
    }

    public function findOneById($id)
    {
        $query = $this->roleRepository->queryFindById($id)->getQuery();

        return $query->getOneOrNullResult();
    }

    public function findOneBySymName($symname)
    {
        $query = $this->roleRepository->queryFindBySymName($symname)->getQuery();

        return $query->getOneOrNullResult();
    }

    public function remove(Role $role)
    {
        $this->entityManager->remove($role);
        $this->entityManager->flush();
    }

    public function save(Role $role)
    {
        $this->entityManager->persist($role);
        $this->entityManager->flush();
    }
}
