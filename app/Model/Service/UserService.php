<?php

declare(strict_types=1);

namespace App\Model\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Model\Entity\User;
use App\Model\Manager\UserManager;


class UserService
{
    private EntityManagerInterface $entityManager;
    private UserManager            $userManager;
    public function __construct(
        EntityManagerInterface $entityManager,
        UserManager            $userManager
    ) {
        $this->entityManager = $entityManager;
        $this->userManager   = $userManager;
    }

    public function findUserByName($name) {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select('u')->from(User::class, 'u')->where('u.name = :name')->setParameter('name', $name);
        $user = $queryBuilder->getQuery()->getResult();
        return $user;
    }

    public function registerUser($data): void {
        $user = $this->userManager->createUser($data);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }


}