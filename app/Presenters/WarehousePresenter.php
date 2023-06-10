<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Component\Form\Warehouse\WarehouseFormFactory;
use Nette;
use Nette\Application\UI\Multiplier;
use Nette\Application\UI\Presenter;
use App\Model\Service\WarehouseService;
use App\Component\Form\Warehouse\WarehouseForm;
use App\Model\Entity\Warehouse;


class WarehousePresenter extends Presenter
{
    private WarehouseFormFactory $warehouseFormFactory;
    private WarehouseService $warehouseService;

    public function __construct(
        WarehouseFormFactory $warehouseFormFactory,
        WarehouseService     $warehouseService
    ) {
        $this->warehouseFormFactory = $warehouseFormFactory;
        $this->warehouseService     = $warehouseService;
    }

    public function renderDefault()
    {
        $warehouses = $this->warehouseService->getAllWarehouses();
        $this->template->warehouses = $warehouses;
    }

    public function createComponentWarehouseForm(): Multiplier {
        return new Multiplier(function ($warehouseId) { // this needs to be changed and be updated dynamically
            $warehouse = null;

            if ($warehouseId !== null) {
                $warehouse = $this->warehouseService->getSpecificWarehouse(intval($warehouseId));
            }
    
            return $this->warehouseFormFactory->create($warehouse);
        });
    }

    public function handleShow() {
        if ($this->isAjax()) {
            
        }
    }

}