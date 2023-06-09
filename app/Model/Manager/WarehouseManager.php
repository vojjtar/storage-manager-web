<?php

namespace App\Model\Manager;

use Doctrine\ORM\EntityManagerInterface;
use App\Model\Entity\Warehouse;


class WarehouseManager
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getStorageEntity($warehouse_id): Warehouse {
        return $this->entityManager->find(Warehouse::class, $warehouse_id);
    }

}