<?php

namespace App\Component\Form\Warehouse;

use App\Model\Entity\Warehouse;
use App\Model\Manager\WarehouseManager;
use App\Model\Service\WarehouseService;


class WarehouseFormFactory implements WarehouseFormFactoryInterface
{
    private WarehouseManager $warehouseManager;
    private WarehouseService $warehouseService;

    public function __construct(
        WarehouseManager $warehouseManager,
        WarehouseService $warehouseService
    ) {
        $this->warehouseManager = $warehouseManager;
        $this->warehouseService = $warehouseService;
    }

    public function create(?Warehouse $warehouse = null): WarehouseForm
    {
        return new WarehouseForm($warehouse, $this->warehouseManager, $this->warehouseService);
    }
}
