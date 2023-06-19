<?php

declare(strict_types=1);

namespace App\Model\Entity;


use Doctrine\ORM\Mapping as ORM;


#[ORM\Table(name: 'warehouse')]
#[ORM\Entity]
class Warehouse
{
    #[ORM\Column(type: 'integer'), ORM\Id, ORM\GeneratedValue(strategy: 'AUTO')]
    private $id;

    #[ORM\Column(type: 'string')]
    private $name;

    #[ORM\Column(type: 'string')]
    private $location;

    #[ORM\Column(type: 'string')]
    private $email;

    #[ORM\Column(type: 'datetime')]
    private $created;


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

    public function getLocation(): string
    {
        return $this->location;
    }

    public function setLocation(string $location): void
    {
        $this->location = $location;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getCreated()
    {
        return $this->created; 
    }

    public function setCreated($created)
    {
        $this->created = $created;
    }

}