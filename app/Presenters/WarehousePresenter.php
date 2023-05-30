<?php

declare(strict_types=1);

namespace App\Presenters;


use Nette;
use Nette\Application\UI\Presenter;
use Nette\Application\UI\Form;
use App\Model\Service\WarehouseService;
use App\Form\WarehouseFormFactory;


class WarehousePresenter extends Presenter
{
    private WarehouseService $warehouseService;
    private WarehouseFormFactory $warehouseFormFactory;

    public function __construct(
        WarehouseService $warehouseService,
        WarehouseFormFactory $warehouseFormFactory
    ) {
        $this->warehouseService = $warehouseService;
        $this->warehouseFormFactory = $warehouseFormFactory;
    }

    public function renderDefault()
    {
        $this->template->warehouses = $this->warehouseService->getWarehouse('all');
    }

    public function createComponentWarehouseForm(): Form {
        $form = $this->warehouseFormFactory->createComponentWarehouseForm();
		$form->onSuccess[] = [$this, 'addWarehouse'];
        return $form;
    }
    public function createComponentWarehouseEditForm(): Form
    {
        $form = $this->warehouseFormFactory->createComponentWarehouseEditForm();
        $form->getComponent('edit')->onClick[] = [$this, 'editWarehouse'];
        $form->getComponent('delete')->onClick[] = [$this, 'deleteWarehouse'];
        return $form;
    }

	public function addWarehouse(Form $form, $data): void {
        $this->warehouseService->addWarehouse($data);
		$this->flashMessage('Storage added.', type:'info');
		//$this->redirect('this');
	}

    public function editWarehouse(Form $form, $data): void {
        $this->warehouseService->editWarehouse($data);
        $this->flashMessage("Warehouse name edited to {$data['name']}", type: 'info');
    }

    public function deleteWarehouse(Form $form, $data): void {
        $this->warehouseService->deleteWarehouse($data);
        $this->flashMessage("Warehouse {$data['name']} was deleted", type: 'info');
    }

}