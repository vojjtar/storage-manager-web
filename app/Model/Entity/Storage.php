<?php

declare(strict_types=1);

namespace App\Model\Entity;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

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

    // #[ORM\Column(type: 'integer')]
    // private $warehouse_id;

    #[ORM\ManyToOne(targetEntity: 'Warehouse', inversedBy: 'storages')]
    // #[ORM\JoinColumn(name: 'warehouse_id', referencedColumnName: 'id')]
    private $warehouse;

    #[ORM\OneToMany(targetEntity: 'StorageHistory', mappedBy: 'storage')]
    private $movements;

    public function __construct()
    {
        $this->movements = new ArrayCollection();
    }


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

    // public function getWarehouseId(): int
    // {
    //     return $this->warehouse_id;
    // }

    // public function setWarehouseId(int $warehouse_id): void
    // {
    //     $this->warehouse_id = $warehouse_id;
    // }

    public function getWarehouse()
    {
        return $this->warehouse;
    }

    public function setWarehouse($warehouse)
    {
        $this->warehouse = $warehouse;
    }

    public function getMovements(): Collection
    {
        return $this->movements;
    }
    
}