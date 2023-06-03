<?php

namespace App\Model\Manager;

use Doctrine\ORM\EntityManagerInterface;


class WarehouseManager
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

}