<?php

namespace App\Model\Manager;

use Doctrine\ORM\EntityManagerInterface;
use App\Model\Entity\User;
use Nette\Security\Passwords;
use Nette\Security\SimpleIdentity;


class UserManager
{
    private EntityManagerInterface $entityManager;
    private Passwords $passwords;

    public function __construct(
        EntityManagerInterface $entityManager,
        Passwords              $passwords
    ) {
        $this->entityManager = $entityManager;
        $this->passwords     = $passwords;
    }

    public function hashUserPassword($password): string {
        return $this->passwords->hash($password);
    }

    public function authenticateUser($name, $password) {
        // $user = $this->userService->findUserByName($name);
        // if ($user) {
        //     $hashPassword = $user->getPassword();
        //     if ($this->passwords->verify($password, $hashPassword)) {
        //         return new SimpleIdentity(
        //             $user->getId(),
        //             ['name' => $user->getName()],
        //         );
        //     }
        // }
        // return false;
    }

    public function createUser($data): User {
        // TODO! could be filling entities in managers instead of services and use services just for db stuff like here

        $user = new User();
        $user->setName($data['name']);
        $user->setEmail($data['email']);
        $user->setPassword($this->hashUserPassword($data['name']));

        return $user;
    }

}   