<?php

declare(strict_types=1);

namespace App\Component\Form\Storage;

use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use App\Model\Entity\Storage;
use App\Model\Service\StorageService;
use App\Model\Service\WarehouseService;


class StorageForm extends Control
{
    public function __construct(
        private Storage|null $storage,
        private StorageService $storageService,
        private WarehouseService $warehouseService
    ) {
        $this->storage = $storage;
        $this->storageService = $storageService;
        $this->warehouseService = $warehouseService;
    }

    public function render(): void {
        if ($this->presenter->showMove) {
            $this->template->render(__DIR__ . '/Template/move.latte');
        } else {
            $this->template->render(__DIR__ . '/Template/default.latte');
        }
    }

    public function createComponentStorageForm(): Form
    {
		$form = new Form;
        $form->addHidden('id', '');
        $form->addHidden('warehouse_id', '');
		$form->addText('name', 'Name:')->setRequired()->setHtmlAttribute('class', 'form-control');
		$form->addText('description', 'Description:')->setRequired()->setHtmlAttribute('class', 'form-control');
		$form->addText('code', 'Code:')->setRequired()->setHtmlAttribute('class', 'form-control');
		$form->addText('price', 'Price ($USD):')->setRequired()->setHtmlAttribute('class', 'form-control');
		$form->addSubmit('send', 'OK')->setHtmlAttribute('class', 'btn btn-primary float-right');

        if ($this->storage !== null) {
            $form->setDefaults([
                'id' => $this->storage->getId(),
                'warehouse_id' => $this->storage->getWarehouseId(),
                'name' => $this->storage->getName(),
                'description' => $this->storage->getDescription(),
                'code' => $this->storage->getCode(),
                'price' => $this->storage->getPrice()
            ]);
        }

        $form->onSuccess[] = [$this, 'storageFormOnSuccess'];

		return $form;
    }

    public function storageFormOnSuccess(Form $form, $data): void {
        if ($data->id !== '') {
            $this->storageService->editStorage($data);
        }
        else {
            $data['warehouse_id'] = intval($this->presenter->getParameter('id')); // getting warehouse_id parameter from the url, could also take it from the template
            $this->storageService->addStorage($data);
        }
        //$this->presenter->redirect('default'); // cant redirect without passing warehouse ID
    }

    public function createComponentMoveStorageForm(): Form
    {
        $form = new Form;
        $warehouses = $this->warehouseService->getAllWarehouses();

        foreach ($warehouses as $warehouse) {
            $form->addButton(strval($warehouse->getId()), $warehouse->getName())->setHtmlAttribute('class', 'btn btn-primary')
                                                                                ->getControlPrototype()->type('submit');
        }
        $form->addHidden('id', '');

        if ($this->storage !== null) {
            $form->setDefaults([
                'id' => $this->storage->getId(),
            ]);
        }

        $form->onSuccess[] = [$this, 'moveStorage'];

        return $form;
    }

    public function moveStorage(Form $form, $data) {
        $this->storageService->moveStorage($data);
        $this->presenter->flashMessage('Storage moved.');
    }
}