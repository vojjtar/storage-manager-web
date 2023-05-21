<?php

declare(strict_types=1);

namespace App\Model\Entity;


use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'storage')]
#[ORM\Entity]
class Storage
{
    #[ORM\Column(type: 'integer'), ORM\Id, ORM\GeneratedValue(strategy: 'AUTO')]
    private $id;

    #[ORM\Column(type: 'string')]
    private $name;

    #[ORM\Column(type: 'string')]
    private $description;

    #[ORM\Column(type: 'integer')]
    private $code;

    #[ORM\Column(type: 'float')]
    private $price;

    #[ORM\Column(type: 'integer')]
    private $warehouse_id;

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

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function setCode(int $code): void
    {
        $this->code = $code;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function getWarehouseId(): int
    {
        return $this->warehouse_id;
    }

    public function setWarehouseId(int $warehouse_id): void
    {
        $this->warehouse_id = $warehouse_id;
    }

}