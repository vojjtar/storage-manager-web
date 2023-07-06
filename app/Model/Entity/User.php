<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'users')]
#[ORM\Entity]
class User
{
    #[ORM\Column(type: 'integer'), ORM\Id, ORM\GeneratedValue(strategy: 'AUTO')]
    private $id;

    #[ORM\Column(type: 'string')]
    private $name;

    #[ORM\Column(type: 'string')]
    private $email;

    #[ORM\Column(type: 'string')]
    private $password;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
}