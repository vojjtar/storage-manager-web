<?php

declare(strict_types=1);

namespace App\Model\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Model\Entity\User;


class UserService
{
    private EntityManagerInterface $entityManager;
    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }


    public function registerUser(string $username, string $password, string $email) {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        
        $user = new User();
        $user->setName(strval($username));
        $user->setEmail(strval($email));
        $user->setPassword(strval($password));
        

    }


}