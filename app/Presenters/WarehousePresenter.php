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
    public int|null $id = null;

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
        $this->template->id = $this->id;
    }

    public function createComponentWarehouseForm(): WarehouseForm {
        $warehouse = null;

        if ($this->id !== null) {
            $warehouse = $this->warehouseService->getSpecificWarehouse($this->id);
        }

        return $this->warehouseFormFactory->create($warehouse);
    }

    public function handleShow($id) {
        if ($this->isAjax()) {
            $this->template->id = intval($id);
            $this->id = intval($id);
            $this->redrawControl('warehouseFormSnippet');
        }
    }

    public function handleWarehouseDelete($id) {
        $this->warehouseService->deleteWarehouse($id);
    }

}