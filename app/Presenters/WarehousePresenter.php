<?php

declare(strict_types=1);

namespace App\Presenters;


use Nette;
use Nette\Application\UI\Presenter;
use Nette\Application\UI\Form;
use App\Component\Form\Warehouse\WarehouseFormFactory;
use App\Model\Manager\WarehouseManager;
use App\Model\Service\WarehouseService;
use App\Component\Form\Warehouse\WarehouseForm;
use App\Model\Entity\Warehouse;


class WarehousePresenter extends Presenter
{
    private WarehouseFormFactory $warehouseFormFactory;
    private WarehouseManager $warehouseManager;
    private WarehouseService $warehouseService;
    private WarehouseForm $warehouseForm;
    public int|null $id = null;

    public function injectDependencies(
        WarehouseFormFactory $warehouseFormFactory,
        WarehouseManager     $warehouseManager,
        WarehouseService     $warehouseService,
        WarehouseForm        $warehouseForm
    ) {
        $this->warehouseFormFactory = $warehouseFormFactory;
        $this->warehouseManager     = $warehouseManager;
        $this->warehouseService     = $warehouseService;
        $this->warehouseForm        = $warehouseForm;
    }

    public function renderDefault()
    {
        $this->template->warehouses = $this->warehouseService->getWarehouse('all');
    }

    public function createComponentWarehouseForm(): Form {


        //$form = $this->warehouseFormFactory->create(null);
        return $this->warehouseForm->createComponentAddEditWarehouseForm();
    }
    // public function createComponentWarehouseForm(): Form
    // {
    //     // $form = $this->warehouseFormFactory->createComponentWarehouseEditForm();
    //     // $form->getComponent('edit')->onClick[] = [$this, 'editWarehouse'];
    //     // $form->getComponent('delete')->onClick[] = [$this, 'deleteWarehouse'];
    //     // return $form;
    //     $form = new Form;
    //     $form->addHidden('id');
	// 	$form->addText('name', 'Name:')->setRequired()->setHtmlAttribute('class', 'form-control')->setDefaultValue($this->getName());
	// 	$form->addText('location', 'Location:')->setRequired()->setHtmlAttribute('class', 'form-control');
	// 	$form->addText('email', 'Owner email:')->setRequired()->setHtmlAttribute('class', 'form-control');
    //     $form->addSubmit('delete', 'Delete')->setHtmlAttribute('class', 'btn btn-primary float-right');
	// 	$form->addSubmit('edit', 'Edit')->setHtmlAttribute('class', 'btn btn-primary');
	// 	return $form;
    // }

	// public function addWarehouse(Form $form, $data): void {
    //     $this->warehouseService->addWarehouse($data);
	// 	$this->flashMessage('Storage added.', type:'info');
	// 	//$this->redirect('this');
	// }

    // public function editWarehouse(Form $form, $data): void {
    //     $this->warehouseService->editWarehouse($data);
    //     $this->flashMessage("Warehouse name edited to {$data['name']}", type: 'info');
    // }

    // public function deleteWarehouse(Form $form, $data): void {
    //     $this->warehouseService->deleteWarehouse($data);
    //     $this->flashMessage("Warehouse {$data['name']} was deleted", type: 'info');
    // }

}