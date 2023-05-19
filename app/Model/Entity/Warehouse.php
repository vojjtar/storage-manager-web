<?php

declare(strict_types=1);

namespace App\Model\Entity;


use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'warehouse')]
#[ORM\Entity]
class Warehouse
{
    #[ORM\Column(type: 'int', nullable: true, generated: true)]
    private $id;

    #[ORM\Column(type: 'string')]
    private $name;

    #[ORM\Column(type: 'string')]
    private $location;


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

}